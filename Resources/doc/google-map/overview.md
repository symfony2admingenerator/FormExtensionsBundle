# Google Map
---------------------------------------

[go back to Table of contents][back-to-index]

[back-to-index]: https://github.com/symfony2admingenerator/FormExtensionsBundle/blob/master/Resources/doc/documentation.md

### Form Type

 `s2a_google_map`
 
### Description

Use google map to pick longitude and latitude.

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

**type:** `string` **default:** `lat`

The name of the latitude field.

#### lng_name

**type:** `string` **default:** `lng`

The name of the longitude field.

#### map_width

**type:** `integer` **default:** `300`

The width of the map.

#### map_height

**type:** `integer` **default:** `300`

The height of the map.

#### default_lat

**type:** `string|boolean` **default:** `51.5`

The starting position on the map.

#### default_lng

**type:** `string|boolean` **default:** `-0.1245`

The starting position on the map.
