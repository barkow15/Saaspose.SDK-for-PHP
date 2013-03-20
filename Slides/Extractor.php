<?php

/*
 * Extract various types of information from the document
 */

class SlideExtractor {

    public $FileName = "";

    public function SlideExtractor($fileName) {
        $this->FileName = $fileName;
    }

    /*
     * Gets total number of images in a presentation
     */

    public function GetImageCount($storageType = "", $storageName = "", $folder = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/images";
            if ($folder != "") {
                $strURI .= "?folder=" . $folder;
            }
            if ($storageName != "") {
                $strURI .= "&storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return count($json->Images->List);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Gets number of images in the specified slide
     * @param $slidenumber
     */

    public function GetSlideImageCount($slidenumber, $storageType = "", $storageName = "", $folder = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slidenumber . "/images";
            if ($folder != "") {
                $strURI .= "?folder=" . $folder;
            }
            if ($storageName != "") {
                $strURI .= "&storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return count($json->Images->List);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Gets all shapes from the specified slide
     * @param $slidenumber
     */

    public function GetShapes($slidenumber, $storageType = "", $storageName = "", $folder = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slidenumber . "/shapes";
            if ($folder != "") {
                $strURI .= "?folder=" . $folder;
            }
            if ($storageName != "") {
                $strURI .= "&storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            $shapes = array();

            foreach ($json->ShapeList->Links as $shape) {

                $signedURI = Utils::Sign($shape->Uri->Href);

                $responseStream = Utils::processCommand($signedURI, "GET", "", "");

                $json = json_decode($responseStream);

                $shapes[] = $json;
            }

            return $shapes;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Get color scheme from the specified slide
     * $slideNumber
     */

    public function GetColorScheme($slideNumber, $storageType = "", $storageName = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            //Build URI to get color scheme
            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "/theme/colorScheme";
            if ($storageName != "") {
                $strURI .= "?storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return $json->ColorScheme;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Get font scheme from the specified slide
     * $slideNumber
     */

    public function GetFontScheme($slideNumber, $storageType = "", $storageName = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            //Build URI to get font scheme
            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "/theme/fontScheme";
            if ($storageName != "") {
                $strURI .= "?storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return $json->FontScheme;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Get format scheme from the specified slide
     * $slideNumber
     */

    public function GetFormatScheme($slideNumber, $storageType = "", $storageName = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            //Build URI to get format scheme
            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "/theme/formatScheme";
            if ($storageName != "") {
                $strURI .= "?storage=" . $storageName;
            }
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return $json->FormatScheme;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Gets placeholder count from a particular slide
     * $slideNumber
     */

    public function GetPlaceholderCount($slideNumber, $storageType = "", $storageName = "", $folder = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "/placeholders";
            if ($folder != "") {
                $strURI .= "?folder=" . $folder;
            }
            if ($storageName != "") {
                $strURI .= "&storage=" . $storageName;
            }
            //Build URI to get placeholders
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return count($json->Placeholders->PlaceholderLinks);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /*
     * Gets a placeholder from a particular slide
     * $slideNumber
     * $placeholderIndex
     */

    public function GetPlaceholder($slideNumber, $placeholderIndex, $storageType = "", $storageName = "", $folder = "") {
        try {
            //check whether file is set or not
            if ($this->FileName == "")
                throw new Exception("No file name specified");

            $strURI = Product::$BaseProductUri . "/slides/" . $this->FileName . "/slides/" . $slideNumber . "/placeholders/" . $placeholderIndex;
            if ($folder != "") {
                $strURI .= "?folder=" . $folder;
            }
            if ($storageName != "") {
                $strURI .= "&storage=" . $storageName;
            }
            //Build URI to get placeholders
            $signedURI = Utils::Sign($strURI);

            $responseStream = Utils::processCommand($signedURI, "GET", "", "");

            $json = json_decode($responseStream);

            return $json->Placeholder;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}