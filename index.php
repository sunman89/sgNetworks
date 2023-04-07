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
        $entry = $doorEntry->getEntryDetails($data);
        return json_encode($entry);
        exit();
        /**
         * get the cn= and test that in the db. Return the json_encoded data.
         */
    break;

    case 'enter-building-test':
        $data['cn'] = '142594708f3a5a3ac2980914a0fc954f'; // Test purposes
        $doorEntry->getEntryDetails($data);
        echo json_encode(['full_name' => $doorEntry->getFullName(), 'department' => $doorEntry->getDepartments()]);
        exit();
    break;

    // Put use cases for adding users. Have add employee and then just pass in values, so can do it from the class.

    case 'upload-image':
        // Try to upload the image to the proper directory.
        $failed = $landing->addImageAndText($data);
        // If it failed, then pass the message through to display it.
        header('Location: landing.php?'.(($failed) ? 'failed='.$failed . '&image_text='.$data['image_text'] :'' ));
    break;

    case 'display':
        // Page to display the actual image.
        $image      = $landing->getImageToDisplay($data);
        $layout     = 'display-image.inc.php';
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