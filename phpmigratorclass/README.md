Twitter's Bootstrap Migrator class
==================================

This PHP class helps you to migrate your Twitter's Bootstrap 2.X to [Twitter Bootstrap 3](http://getbootstrap.com/).

Demo: [Twitter's Bootstrap Migrator](http://twitterbootstrapmigrator.w3masters.nl/)

Usage:
------

    require('bootstrapmigration2to3.php');
    $migrator = new bootstrapmigration2to3($template);
    list($newtemplate,$errors,$warnings) = $migrator->migrate();
    
References:
-----------
 - [Bootstrap 3 Migration Guide](http://bootply.com/bootstrap-3-migration-guide)
 - [http://bassjobsen.weblogs.fm/migrate-your-templates-from-twitter-bootstrap-2-x-to-twitter-bootstrap-3/](http://bassjobsen.weblogs.fm/migrate-your-templates-from-twitter-bootstrap-2-x-to-twitter-bootstrap-3/)
