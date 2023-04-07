<?php 
/*
|----------------------------------------------------------------------------
| Door Entry Class
|----------------------------------------------------------------------------
*/
class DoorEntry    
{
    private $db;
    private $username;
    private $departments;

    /*
    |--------------------------------------------------------------------------
    | Setup our constructor. So can access the database and other private fields.
    |--------------------------------------------------------------------------
    */    
    public function __construct($db)
    {
        $this->db       = $db;
        $this->username = [];
        $this->departments = [];
    }

    public function getFullName()
    {
        return $this->username;
    }

    public function getDepartments()
    {
        return $this->departments;
    }

    private function setFullName($fname, $sname)
    {
        $this->username = ($sname) ? $fname . ' ' . $sname : $fname; // If have a surname, then concat the first name and surname. Otherwise just add the first name.
    }

    private function setDepartments($departments)
    {
        // Could do something here like test if the $departments is an array/object. But decided not to.
        $this->departments = $departments;
    }

    /**
     * Function to format the passed in array to clean the inputted values. Mostly for the $_REQUEST.
     */
    public function formatAll($array)
    {
        foreach($array as $key => $value)
        {
            if(!is_array($array[$key])) $array[$key] = htmlspecialchars($value);
        }
        return $array;
    }

    // Get the employee from the db. If not found, will return an empty array.
    public function getEmployeeFromDb($cn)
    {
        if(!$cn) return false;
        return $this->db->get('SELECT * FROM employees WHERE rfid_number = ?', [$cn]);
    }

    // Get the departments for an employee from the db. If not found, will return an empty array.
    public function getEmployeeDepartmentsFromDb($id)
    {
        if(!$id) return false;
        return $this->db->get_all('SELECT ed.*, d.*
        FROM employee_departments ed
        LEFT JOIN departments d ON ed.department_id = d.department_id
        WHERE ed.employee_id = ?
        ORDER BY d.department_id ASC', [$id]);
    }

    // Get the buildings linked to departments for this department.
    public function getBuildingDepartmentsFromDb($id)
    {
        if(!$id) return false;
        return $this->db->get_all('SELECT bd.*, b.*
        FROM buildings_departments bd
        LEFT JOIN buildings b ON bd.building_id = b.building_id
        WHERE bd.department_id = ?
        ORDER BY b.building_id ASC', [$id]);
    }

    /**
     * Main function.
     * Pass in an array called $data, which is just the values from the url $_REQUEST.
     * Check for a card number (cn). If has one, then check if it exists in the db. If so, retreive that employee and the departments. Setting them into the variable to be used later on.
     */
    public function getEntryDetails($data)
    {
        if(!$data) return false;
        if(!array_key_exists('cn', $data)) return false; // Check if card number exists in the URL params.
        if(strlen($data['cn']) != 32) return false;

        // Need to first get the employee.
        $employee = $this->getEmployeeFromDb($data['cn']);

        // Check if employee was found.
        if($employee)
        {
            $this->setFullName($employee['fname'], $employee['sname']); // Set the name

            // Now get the departments for the user.
            $departments = $this->getEmployeeDepartmentsFromDb($employee['employee_id']);
            if($departments)
            {
                $temp = [];
                foreach($departments as $department) $temp[] = $department['department_name']; // Store each department name
                $this->setDepartments($temp); // set the departments
            }
        }
        // echo '<pre>';print_r($employee);print_r($departments);echo '</pre>';exit();  Was using this code to test what was returned from the database.
    }

    // Just a test to add an employee.
    public function addEmployee()
    {
        $text = 'Employee Added';
        $id = $this->db->insert('INSERT INTO employees (fname, sname, rfid_number) VALUES (?,?,?)',[
            'Sonny',
            'Stokes',
            '142594708f3a5a3ac2980914a0fc954g'
        ]);
        if(!$id) $text = 'Error: failed to add employee';
        return $text;
    }

    // Just a test to add departments to an employee
    public function addDepartmentsToEmployee($employee_id = 0)
    {
        $text = 'Departments added successfully';
        if(!isset($employee_id)) $text = 'Error: No employee ID given';

        // Get that employee first.
        $user = $this->db->get('SELECT * FROM employees WHERE employee_id = ?', [$employee_id]);
        if(!$user) $text = 'No employee with that ID';
        else
        {
            $departments = [1,2,3,4,5];
            foreach($departments as $department)
            {
                $this->db->insert('INSERT INTO employee_departments (employee_id, department_id) VALUES (?,?)',[
                    $employee_id,
                    $department
                ]);
            }
        }
        return $text;
    }

    public function getAllDataForEmployee($cn)
    {
        if(!isset($cn)) return false;
        if(strlen($cn) != 32) return false;

        $result = [];

        // Need to first get the employee.
        $result['employee'] = $this->getEmployeeFromDb($cn);

        // Check if employee was found.
        if($result['employee'])
        {
            // Now get the departments for the user.
            $result['departments'] = $this->getEmployeeDepartmentsFromDb($result['employee']['employee_id']);

            for($i=0;$i<count($result['departments']);$i++)
            {
                // Get the buildings that have those departments.
                $result['departments'][$i]['buildings'] = $this->getBuildingDepartmentsFromDb($result['departments'][$i]['department_id']);
            }
        }
        return $result;
    }
}

?>