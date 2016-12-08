<?php if (!empty($_SERVER['SCRIPT_FILENAME']) && 'footer.php' == basename($_SERVER['SCRIPT_FILENAME'])) 
    die('Please do not load this page directly. Thanks!'); ?>


<div id="footer">
  <div id="inner-footer" class="wrap clearfix">
    <div>

   <?php if (class_exists('\\menu\\Create_Menus')) {
    \menu\Create_Menus::footer_links();
} else {
    echo 'No class called Create Menus has been found';
} ?>
      
      
    </div>
    <p class="attribution">&copy; <?php echo date('Y'); ?>
      <?php bloginfo('name'); ?>
      .</p>
  </div>
  <!-- end #inner-footer --> 
  
</div>
<!-- end footer -->

</div>
<!-- end #wrapper -->

<?php wp_footer(); // js scripts are inserted using this function ?>
</body></html>