<?php
//This Class For Convert the Website On different Language/Culture
// Author : zerocall
//Copy Right: zerocall.com
//Creatation date : 24/01/11
class changeLanguageCulture{

    public static function languageCulture($request,$clsObj)
    {
     
        // Retrieve data from the user session with a default value
        $activelanguage = $clsObj->getUser()->getAttribute('activelanguage', '');

        //------------------------Set Culture - Code Add By - Ahtsham - ZeroCall - Against Feature#6.1
        

        if(sfConfig::get('sf_app')=='agent'){
            $clsObj->getUser()->setCulture('en');
            $getCultue = $clsObj->getUser()->getCulture();
            // Store data in the user session
                    $clsObj->getUser()->setAttribute('activelanguage', $getCultue);
        }else{
                              
           if($request->getParameter('language')=='en'){
               // echo 'Before'.$clsObj->getUser()->getCulture();
                $clsObj->getUser()->setCulture('en');
                $getCultue = $clsObj->getUser()->getCulture();
                 // Store data in the user session
                // echo ' GetCulture:'. $getCultue;
                $clsObj->getUser()->setAttribute('activelanguage', $getCultue);

            }else if($request->getParameter('language')=='no'){
                $clsObj->getUser()->setCulture('no');
                $getCultue = $clsObj->getUser()->getCulture();
                 // Store data in the user session
                $clsObj->getUser()->setAttribute('activelanguage', $getCultue);
                //$languages = $request->getLanguages();
               // $language = $request->getPreferredCulture(array('en', 'fr'));
            }else{

                $clsObj->getUser()->setCulture('no');
                $getCultue = $clsObj->getUser()->getCulture();
                // Store data in the user session
                $clsObj->getUser()->setAttribute('activelanguage', $getCultue);

                //----------------------End Code -------------------------------               
            }
        }
        
        //-----------------------------------------
      }
}
?>