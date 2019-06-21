<?php
/**
 * A helper class for handling media file uploads
 *
 * @package   Calligraphic Job Board
 * @version   0.1 May 1, 2018
 * @author    Calligraphic, LLC http://www.calligraphic.design
 * @copyright Copyright (C) 2018 Calligraphic, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * This helper is designed to use a single name for the file type input field
 * e.g. it won't handle multiple differently-named file type input fields in a single form
 *
 * <form action="file-upload.php" method="post" enctype="multipart/form-data">
 *   <input name="file_upload[]" type="file" accept=".jpg, image/png" multiple />
 *   <input type="submit" value="Send files" />
 * </form>
 *
 * The multiple flag is optional. The accept field can also be a type specifier meaning "any":
 *   audio/*, video/*, image/*
 */

namespace Calligraphic\Cajobboard\Admin\Helper;

use \FOF30\Container\Container;
use \FOF30\Model\DataModel;
use \FOF30\Input\Input;
use \Joomla\CMS\Filesystem\File;
use \Joomla\CMS\Filesystem\Folder;
use \Joomla\CMS\Language\Text;

// no direct access
defined('_JEXEC') or die;

class Uploader
{
  /**
	 * The container attached to the model
	 *
	 * @var Container
	 */
  protected $container;


  /**
	 * The name of the model the file was uploaded to
	 *
	 * @var string
	 */
  protected $modelName;


  /**
	 * An array of objects holding file upload metadata
	 *
	 * @var string
	 */
  protected $files = array();


  /**
	 * The name of the input field in the HTML form that has type 'file'
	 *
	 * @var string
	 */
  protected $formFieldName = 'file_upload';


  /**
	 * The name of the input field in the HTML form that has type 'file'
	 *
	 * @var string
	 */
  protected $destDir = 'media';


  /**
	 * An array of allowed file extensions (key) and MIME types (value)
	 *
	 * @var string
	 */
  protected $allowedFileTypes = array(
    "jpg" => "image/jpg",
    "jpeg" => "image/jpeg",
    "gif" => "image/gif",
    "png" => "image/png",
    'svg' => 'image/svg+xml'
  );


  /*
    Security issues are:
      1. Allowing users to download a file before it is fully verified as safe.
         Use a temp directory outside of the web root to store file before it is moved.

      2. Allowing file uploads to overwrite existing files.

      3. Allowing dangerous file extensions / mime types (e.g. .php, )

      4. Problem of renaming a file e.g. to a .txt extension, and name results in .php.txt or
         setting an EXIF field or the image body to tagged PHP code (<?php or <?= and ?> tags)
         in an image file and the image file is included or exec'd


      5. Danger of user filenames like "../../../../../../var/www/yoursite.com/index.php"
         Use basename() and realpath(), or the Joomla! wrappers for them.

      6. Make sure it's a valid file for the MIME type. Verify image files:
          getimagesize($filename [, array &$imageinfo ])
            $imageinfo[0] is width, [1] is height


      7. Set up Joomla's .htaccess file and disable CGI script execution in the /media directory:

          <Directory /var/www/joomla/>media>
            # Disable script execution
            AddHandler cgi-script .php .pl .py .jsp .asp .htm .shtml .sh .cgi
            Options -ExecCGI

            # Whitelist file extensions
            <FilesMatch "\.(jpeg|pdf)$">
              Allow from all
            </FilesMatch>

            # Blacklist file extensions
            <FilesMatch "\.(asp|php|php5|pl)$">
              Deny from all
            </FilesMatch>

            # only allow images to be associated with their default handlers
            ForceType application/octet-stream

            <FilesMatch "(?i).jpe?g$">
                ForceType image/jpeg
            </FilesMatch>

            <FilesMatch "(?i).gif$">
                ForceType image/gif
            </FilesMatch>

            <FilesMatch "(?i).png$">
                ForceType image/png
            </FilesMatch>
          </Directory>

      8. Rename uploaded files to a system-generated random name

      9. The script bringing tricked into working on a file that wasn't uploaded (like /etc/passwd)
          is_uploaded_file()  tells whether the file was uploaded via HTTP POST
  */


  /**
	 * Format a date for display.
   *
   * The $config parameter can be used to pass some configuration values to the object:
   *
   *  form_field_name   Set the name of the input field in the HTML form that has type 'file'
   *
	 * @param   DataModel  $model      The container attached to the model.
	 * @param   array      $config     Configuration values for this uploader.
	 */
	public function __construct(DataModel $model, array $config = array())
	{
    $this->container = $model->getContainer();
    $this->modelName = $modelgetName();

    if (isset($config['formFieldName']))
		{
			$this->formFieldName = $config['formFieldName'];
    }

    if (isset($config['destDir']))
		{
			$this->destDir = $config['destDir'];
    }

    if (isset($config['allowedFileTypes']))
		{
			$this->allowedFileTypes = $config['allowedFileTypes'];
    }

    // Retrieve file details from uploaded file, sent from upload form
    $this->initFileList( $this->container->input->get($this->formFieldName) );
  }


  // @TODO: Is array?

  if ( !isset($file) )
  {
    throw new \Exception('file not set');
  }

  if ($file['error'] != UPLOAD_ERR_OK)
  {
    throw new UploadException($file['error']);
  }

  //check for filesize
  $fileSize = $file['size'];

  if($fileSize > 2000000)
  {
    throw new \Exception( JText::_('FILE BIGGER THAN 2MB') );
  }

  // Clean up filename to get rid of strange characters like spaces etc
  $fileName =JFile::makeSafe($file['name']);

  $extension = strtolower(JFile::getExt($filename));

  if( !array_key_exists($extension, $allowed) )
  {
    throw new \Exception( JText::_('INVALID EXTENSION') );
  }

  //the name of the file in PHP's temp directory that we are going to move to our folder
  $fileTemp = $file['tmp_name'];

  // for security purposes, we will also do a getimagesize on the temp file (before we have moved it
  // to the folder) to check the MIME type of the file, and whether it has a width and height
  // Returns false on failure, E_WARNING if it can't access the filename, and E_NOTICE on read error.
  // Downloads the entire image before it checks for the requested information.
  $imageinfo = getimagesize($fileTemp);

  //if the temp file does not have a width or a height
  if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) )
  {
    throw new \Exception( JText::_( 'MISSING WIDTH OR HEIGHT DIMENSION' ) );
  }

  // $imageinfo[2] is a text string with the correct height="yyy" width="xxx" string that can be used directly in an IMG tag

  // if the temp file has a non-allowed MIME type

  // also mime_content_type($filename) returns the mime type, e.g.  text/plain and false on failure, instead of relying on what the client says

  // Convert extension to MIME type:
  // composer require ralouphie/mimey
  // $mimes = new \Mimey\MimeTypes;
  // $mimes->getMimeType('json'); // application/json

  // Convert MIME type to extension:
  // $mimes->getExtension('application/json'); // json
  if( !in_array( $imageinfo['mime'], array_values($allowed) ) )
  {
    throw new \Exception( JText::_( 'INVALID  MIME TYPE' ) );
  }

  // also, for linux:
  function detectFileMimeType($filename='')
  {
      $filename = escapeshellcmd($filename);
      $command = "file -b --mime-type -m /usr/share/misc/magic {$filename}";

      $mimeType = shell_exec($command);

      return trim($mimeType);
  }

  if(in_array($filetype, $allowed))
  {
      // Check whether file exists before uploading it
      if(file_exists($destDir . $filename))
      {
        throw new \Exception( JText::printf("File %s already exists.", $filename));
      }
      else
      {
        // Set up the source and destination of the file
        $src = $file['tmp_name'];

        JFile::upload($src, $destDir)

        echo "Your file was uploaded successfully.";
      }
  }
  else
  {
    throw new \Exception(JText::_("Error: There was a problem uploading your file. Please try again."));
  }

  //lose any special characters in the filename
  $fileName = preg_replace("/[^A-Za-z0-9]/i", "-", $fileName);

  //always use constants when making file paths, to avoid the possibilty of remote file inclusion
  $uploadPath = JPATH_SITE.DS.'images'.DS.'stories'.DS.$fileName;

  if(!JFile::upload($fileTemp, $uploadPath))
  {
    echo JText::_( 'ERROR MOVING FILE' );

    return;
  }
  else
  {
     // success, exit with code 0 for Mac users, otherwise they receive an IO Error
     exit(0);
  }


  /**
	 * Normalize PHP's $_FILES global to a class property
	 *
	 * @param   array   $files   $_FILES global from input
	 */
  public function initFileList($files)
  {
    foreach($files as $name => $fileArray)
    {
      // When multiple files are uploaded, each key is an array e.g. 'name' is an array of all file names uploaded
      if (is_array($fileArray['name']))
      {
        // attributes are name, type, size, tmp_name, and error
        foreach ($fileArray as $attrib => $list)
        {
          foreach ($list as $index => $value)
          {
            $this->files[$name][$index][$attrib]=$value;
          }
        }
      }
      // Single file was uploaded
      else
      {
        $this->files[$name][] = $fileArray;
      }
    }
  }


}

* $_FILES["file_upload"]["name"]      // This array value specifies the original name of the file, including the file extension. It doesn't include the file path.
* $_FILES["file_upload"]["type"]      // This array value specifies the MIME type of the file.
* $_FILES["file_upload"]["size"]      // This array value specifies the file size, in bytes.
* $_FILES["file_upload"]["tmp_name"]  // This array value specifies the temporary name including full path that is assigned to the file once it has been uploaded to the server.
* $_FILES["file_upload"]["error"]     // This array value specifies error or status code associated with the file upload, e.g. it will be 0, if there is no error.
