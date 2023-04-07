<?php
/**
 * Do the actions here
 */
require __DIR__ . DIRECTORY_SEPARATOR . 'initialise.php';
require __DIR__ . '/models/DoorEntry.php';

$doorEntry = new DoorEntry($db);
if(!isset($_REQUEST['action'])) $_REQUEST['action'] = 'enter-building';
$data = $doorEntry->formatAll($_REQUEST); // Clean up the url params.

/*
|--------------------------------------------------------------------------
| Determine the action required for the model and prepare includes for view
|--------------------------------------------------------------------------
*/
switch($_REQUEST['action'])
{
    case 'enter-building':
        // Main action to just return the credentials in a JSON format. As long as have a cn="" in the URL.
        $entry = $doorEntry->getEntryDetails($data);
        echo json_encode($entry);
        exit();
    break;

    case 'enter-building-test':
        $data['cn'] = '142594708f3a5a3ac2980914a0fc954f'; // Test purposes exact match
        // $data['cn'] = '142594708f3a5a3ac2980914a0fc954fgdsfh'; // Too long number
        // $data['cn'] = '142594708f3a5a3'; // Too short number
        $doorEntry->getEntryDetails($data);
        echo json_encode(['full_name' => $doorEntry->getFullName(), 'department' => $doorEntry->getDepartments()]);
        exit();
    break;

    case 'add-employee-test':
        $added = $doorEntry->addEmployee();
        echo $added;
        exit();
    break;

    case 'add-employee-departments-test':
        $data['id'] = 2; // Can change this to be any employee taht exists
        $added = $doorEntry->addDepartmentsToEmployee($data['id']);
        echo $added;
        exit();
    break;

    case 'all-employee-data-test':
        $data['cn'] = '142594708f3a5a3ac2980914a0fc954f'; // Test purposes
        // $data['cn'] = '142594708f3a5a3ac2980914a0fc954g'; // Test purposes
        $result = $doorEntry->getAllDataForEmployee($data['cn']);
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit();
    break;

    /*
    |--------------------------------------------------------------------------
    | Default
    |--------------------------------------------------------------------------
    */
    default:
        echo ("Error. No Action.");
        exit();
    break; 
}
?>