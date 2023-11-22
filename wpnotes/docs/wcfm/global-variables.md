# Global variables

* **WCFM:** 
 
```php
include_once( 'core/class-wcfm.php' );
global $WCFM;
$WCFM = new WCFM( __FILE__ );
$GLOBALS['WCFM'] = $WCFM;
```

```php
include_once( 'core/class-wcfm-query.php' );
global $WCFM_Query;
$WCFM_Query = new WCFM_Query();
$GLOBALS['WCFM_Query'] = $WCFM_Query;
```
