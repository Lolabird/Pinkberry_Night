<?php
/**
 * Percepress theme based on the DokuWiki Starter Template
 *
 * @link     http://dokuwiki.org/template:starter
 * @link	   https://octavianichols.com
 * @author   Anika Henke <anika@selfthinker.org>
 * @author   Octavia Nichols <octavia@octavianichols.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
$sidebarElement = tpl_getConf('sidebarIsNav') ? 'nav' : 'aside';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body>
    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>
    <div id="dokuwiki__site"><div id="dokuwiki__top" class="site <?php echo tpl_classes(); ?> <?php
        echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>
        
        <!-- ********** HEADER ********** -->
        <header id="dokuwiki__header"><div class="pad">
            <?php tpl_includeFile('header.html') ?>
            <div class="headings">
                <h1>
                <br>
                <?php
		           // get logo either out of the template images folder or data/media folder
		           $logoSize = array();
		           $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);
	
		           // display logo and wiki title in a link to the home page
		           tpl_link(
		               wl(),
		               '<img src="'.$logo.'" '.$logoSize[3].' alt="" /> <span>'.$conf['title'].'</span>',
		               'accesskey="h" title="[H]"'
		           );
	           ?>
                </h1>
                <?php if ($conf['tagline']): ?>
                    <p class="claim"><?php echo $conf['tagline'] ?></p>
                <?php endif ?>

                <ul class="a11y skip">
                    <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a></li>
                </ul>
                <div class="clearer"></div>
            </div>

            <div class="tools">
                <!-- USER TOOLS -->
                <?php if ($conf['useacl'] && $showTools): ?>
                    <nav id="dokuwiki__usertools" aria-labelledby="dokuwiki__usertools_heading">
                        <h3 class="a11y" id="dokuwiki__usertools_heading"><?php echo $lang['user_tools'] ?></h3>
                        <ul>
                            <?php 
			                 if (!empty($_SERVER['REMOTE_USER'])) {
			                     echo '<li class="user">';
			                     tpl_userinfo(); /* 'Logged in as ...' */
			                     echo '</li>';
			                 } 
			             ?>
			             <?php tpl_searchform() ?>
                            <?php 
	                           if (file_exists(DOKU_INC . 'inc/Menu/UserMenu.php')) {
	                               /* the first parameter is for an additional class, the second for if SVGs should be added */
	                               //echo (new \dokuwiki\Menu\UserMenu())->getListItems('action ', false);
	                           } else {
	                               /* tool menu before Greebo */
	                             //  _tpl_usertools();
	                           } 
                            ?>
                        </ul>
                    </nav>
                <?php endif ?>
            </div>
            <div class="clearer"></div>
		  
            <!-- BREADCRUMBS -->
            <?php if($conf['breadcrumbs']){ ?>
                <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
            <?php } ?>
            <?php if($conf['youarehere']){ ?>
                <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
            <?php } ?>
            <br>

            <div class="clearer"></div>
            <hr class="a11y" />
        </div></header><!-- /header -->

        <div class="wrapper">

            <!-- ********** CONTENT ********** -->
            <main id="dokuwiki__content">
                
               <?php tpl_toc(); ?>
	           
	           <div class="pad">
	               <?php tpl_flush() /* flush the output buffer */ ?>
	               <?php tpl_includeFile('pageheader.html') ?>
	
	               <div class="page">
	                   <!-- wikipage start -->
	                   <?php tpl_content(false) /* the main content */ ?>
	                   <!-- wikipage stop -->
	                   <div class="clearer"></div>
	               </div>
	
	               <?php tpl_flush() ?>
	               <?php tpl_includeFile('pagefooter.html') ?>
	           </div>
            </main><!-- /content -->

            <div class="clearer"></div>
            <hr class="a11y" />

        </div><!-- /wrapper -->

        <!-- PAGE ACTIONS -->
            <?php if ($showTools): ?>
                <nav id="dokuwiki__pagetools" aria-labelledby="dokuwiki__pagetools_heading">
                    <h3 class="a11y" id="dokuwiki__pagetools_heading"><?php echo $lang['page_tools'] ?></h3>
                    <ul>
                       <?php
		               // mobile menu (combines all menus in one dropdown)
	                 	if (file_exists(DOKU_INC . 'inc/Menu/MobileMenu.php')) {
	                        echo (new \dokuwiki\Menu\MobileMenu())->getDropdown($lang['tools']);
		           	} else {
		                   tpl_actiondropdown($lang['tools']);
		          	}
		       	 ?>
		       	 <a href="#dokuwiki__top">Back to top</a></top>
                    </ul>
                </nav>
            <?php endif; ?>
        
        <!-- ********** FOOTER ********** -->
        <footer id="dokuwiki__footer"><div class="pad">
            <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
            <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>

            <?php tpl_includeFile('footer.html') ?>
        </div></footer><!-- /footer -->

        <div class="clearer"></div>
        <hr class="a11y" /><br><br>

        <!-- ********** ASIDE ********** -->
           
            <?php if ($showSidebar): ?>
                <<?php echo $sidebarElement ?> id="dokuwiki__aside" aria-label="<?php echo $lang['sidebar'] ?>">
                <div class="pad aside include group">
                    <?php tpl_includeFile('sidebarheader.html') ?>
                    <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
                    <?php tpl_includeFile('sidebarfooter.html') ?>
                    <div class="clearer"></div>
                </div></<?php echo $sidebarElement ?>><!-- /aside -->
            <?php endif; ?>
    
    </div>

    <div id="__top">
    
    </div><!-- /site -->

    <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>

    <script src="script.js"></script>
</body>
</html>
