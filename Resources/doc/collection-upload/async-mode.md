# Collection Upload: Asynchronous upload
---------------------------------------

[go back to Table of contents][back-to-index]

[go back to CollectionUploadType documentation][back-to-collectionupload-type]

[back-to-index]: https://github.com/symfony2admingenerator/FormExtensionsBundle/blob/master/Resources/doc/documentation.md
[back-to-collectionupload-type]: https://github.com/symfony2admingenerator/FormExtensionsBundle/blob/master/Resources/doc/collection-upload/overview.md 

### 1. Description

 CollectionUploadType is, by default, configured to upload selected files when form is submited. With asynchronous mode,
 you can pre-upload files and speed up form submission. Other advantages are, in asynchronous upload, you can select
 files from different folders (something you cannot done with sync mode). Drawbacks are potential unwanted files
 uploaded on the server (you maybe want to create a cron to clean the temporary upload directory, see below).
 
 Thanks to a listener, all process is managed by Avocode. You just have to activate it and configure your fields.
 
 
### 2. Activate async mode

#### Configuration

 To activate asynchronous mode you first need to enable the listener. Here is an example of configuration:
 
```yaml
    admingenerator_form_extensions:
        collection_upload:
            async_listener_enabled: true
            async_route_name: admingenerator_async_upload # see note below
            file_storage: admingenerator.form.file_storage.local
```

 For this config to work, you have to import the `admingenerator_async_upload` route, by adding to your `routing.yml`:

```yaml
s2a_formextensions:
  resource: "@AdmingeneratorFormExtensionsBundle/Resources/config/routing.yml"
  prefix: /my_async_upload_prefix
```

> **Note:** if for any reason you want to use diffrent route name, create your own route instead of importing the default and change the `admingenerator_form_extensions.collection_upload.async_route_name` parameter accordingly.
 
##### async_listener_enabled

**type:** `boolean` **default:** `false`

Wether the listener handling asynchronous file upload should be activated?

##### async_route_name

**type:** `string` **default:** `null`

Required if `async_listener_enabled` is `true`.

Specify the route name used for asynchronous upload.

##### file_storage

**type:** `string` **default:** `admingenerator.form.file_storage.local`

Specify the file storage handler for saving and retrieving asynchronous uploaded files (see below).

#### Form builder options
 
 To activate asynchronous mode you then need to configure form fields options. If you don't, your form still use synchronous
 upload. This allows you to have some CollectionUploadType using the synchronous mode and some other using the asynchronous
 one in the same application.
 
 Here is an example of configuration:
 
 ```php
    <?php

    ...
    
    class MyAmazingType extends AbstractType
    {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder->add(
                'my_field',
                's2a_collection_upload',
                array(
                    'required' => false,
                    'nameable' => false,
                    'nameable_field' => null,
                    'sortable' => false,
                    'type' => 'my_other_amazing_type',
                    'previewMaxWidth' => 80,
                    'previewMaxHeight' => 60,
                    'acceptFileTypes' => '/^image\\/(gif|jpeg|png)$/',
                    'allow_add' => true,
                    'allow_delete' => true,
                    'error_bubbling' => false,
                    'uploadRouteName' => 'admingenerator_async_upload', // must be the same as in the configuration
                    'autoUpload' => true
                );
        }
        
        public function getName()
        {
            return 'my_amazing';
        }
    }
     
 ```
 
 > *Note:* Activating the `autoUpload` mode or defining the `uploadRouteName` automatically mean "asynchronous upload mode
 activated".
 
#### 3. Customize upload file handler

 By default, the bundle provides a simple local storage system for asynchronous uploaded files. This is handled by 
 `Storage\LocalFileStorage` class (service `admingenerator.form.file_storage.local`). This class uses the session to keep
 a list of uploaded files and store them on the default file system temporary directory. This handler has some known 
 limitations (like load balancing issues, eventually requires a cron to clean unused files).
 
 If you want to create your own file handler you have to proceed in two steps
 
 - create your own service (class) implementing the interface `Avocode\FormExtensionsBundle\Storage\FileStorageInterface`
 - update `admingenerator_form_extensions` configuration with your new service:
    
```yaml
    admingenerator_form_extensions:
        collection_upload:
            async_listener_enabled: true
            async_route_name: my_upload_route
            file_storage: your_custom_service_here
```
 
 An adapter for `Gaufrette` is coming. 

 