# Google Map
---------------------------------------

[go back to Table of contents][back-to-index]

[back-to-index]: https://github.com/symfony2admingenerator/FormExtensionsBundle/blob/master/Resources/doc/documentation.md

### Form Type

 `s2a_google_map`
 
### Description

Google map to pick longitude and latitude. Based on [ollietb/OhGoogleMapFormTypeBundle](https://github.com/ollietb/OhGoogleMapFormTypeBundle).

> **Note:** You must set the configuration `admingenerator_form_extensions.include_gmaps: true` or include GMAPS manually.

On your model you will have to process the latitude and longitude array:

```php
<?php
// Your model eg, src/My/Location/Entity/MyLocation.php
use Symfony\Component\Validator\Constraints as Assert;
use Admingenerator\FormExtensionsBundle\Validator\Constraints as S2A;

class MyLocation
{
    // ... include your lat and lng fields here

    public function setLatLng($latlng)
    {
        $this->setLat($latlng['lat']);
        $this->setLng($latlng['lng']);
        return $this;
    }

    /**
     * @Assert\NotBlank()
     * @S2A\LatLng()
     */
    public function getLatLng()
    {
        return array(
            'lat' => $this->getLat(),
            'lng' => $this->getLng()
        );
    }
}
?>
```

### Options

#### type

**type:** `string` **default:** `text`

The type to render the latitude and longitude fields as.

#### options

**type:** `array` **default:** `array()`

The options for both the fields. Can be overriden per field.

#### lat_options

**type:** `array` **default:** `array()`

The options for latitude field.

#### lng_options

**type:** `array` **default:** `array()`

The options for longitude field.

#### lat_name

**type:** `string` **default:** `latitude`

The name of the latitude field.

#### lng_name

**type:** `string` **default:** `longitude`

The name of the longitude field.

#### map_width

**type:** `string|null` **default:** `null`

The width of the map. If set CSS width style will be added.

#### map_height

**type:** `string|null` **default:** `null`

The height of the map. If set CSS height style will be added.

#### default_lat

**type:** `string|boolean` **default:** `51.5`

The default starting position on the map is Greenwitch, London.

#### default_lng

**type:** `string|boolean` **default:** `-0.1245`

The default starting position on the map is Greenwitch, London.

#### callback

**type:** `string` **default:** `function (location, gmap) {}`

Javascript callback function.

#### error_handler

**type:** `string` **default:** `function (elem, status) {}`

Javascript error handler function.

