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

    public function getEmployeeFromDb($cn)
    {
        if(!$cn) return false;
        return $this->db->get('SELECT * FROM employees WHERE rfid_number = ?', [$cn]);
    }

    public function getEmployeeDepartmentsFromDb($id)
    {
        if(!$id) return false;
        return $this->db->get('SELECT ed.*, d.*
        FROM employee_departments ed
        LEFT JOIN departments d ON ed.department_id = d.department_id
        WHERE ed.employee_id = ?
        ORDER BY d.department_id ASC', [$id]);
    }

    public function getEntryDetails($data)
    {
        if(!$data) return false;
        elseif(!array_key_exists('cn', $data)) return false;

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
                foreach($departments as $department)
                {
                    $temp[] = $department['department_name'];
                }
                $this->setDepartments($temp);
            }
        }
        // echo '<pre>';print_r($employee);print_r($departments);echo '</pre>';exit();

    }
}

?>