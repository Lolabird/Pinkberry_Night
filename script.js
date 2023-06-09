// template-related scripts go here... 
/*jQuery(function() {
    var $toc = jQuery('#dw__toc .toggle');
    if($toc.length) {
        $toc[0].setState(-1);
    }
});*/

jQuery(function() {
    var $tocHeader = jQuery('#dw__toc .toggle');
    var $tocContent = $tocHeader.next(); // Assuming the contents of TOC are right after the toggle element
    
    if ($tocHeader.length && $tocContent.length) {
        if (window.innerWidth >= 960) {
            $tocContent.css('display', 'block');
        } else {
            $tocContent.css('display', 'none');
        }
    }
});
