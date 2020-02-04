//Namespaces and autoloading in Drupal 8


use in "Execute PHP Code" of "Devel"

$our_service = \Drupal::service('custdrupal_service.cow');
kint($our_service->whoIsYourOwner());
die();


in "custdrupal_service.services.yml" file
custdrupal_service.cow:
where cow is unique name of service