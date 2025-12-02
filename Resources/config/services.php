<?php

use Admingenerator\FormExtensionsBundle\EventListener\UploadCollectionListener;
use Admingenerator\FormExtensionsBundle\Form\Type\BootstrapFieldsetCollectionType;
use Admingenerator\FormExtensionsBundle\Form\Type\BootstrapTableCollectionType;
use Admingenerator\FormExtensionsBundle\Form\Type\DatePickerType;
use Admingenerator\FormExtensionsBundle\Form\Type\DateRangePickerType;
use Admingenerator\FormExtensionsBundle\Form\Type\DateTimePickerType;
use Admingenerator\FormExtensionsBundle\Form\Type\DoubleListDocumentType;
use Admingenerator\FormExtensionsBundle\Form\Type\DoubleListEntityType;
use Admingenerator\FormExtensionsBundle\Form\Type\DoubleListModelType;
use Admingenerator\FormExtensionsBundle\Form\Type\ElasticTextareaType;
use Admingenerator\FormExtensionsBundle\Form\Type\GoogleMapType;
use Admingenerator\FormExtensionsBundle\Form\Type\KnobType;
use Admingenerator\FormExtensionsBundle\Form\Type\MiniColorsType;
use Admingenerator\FormExtensionsBundle\Form\Type\MoneyType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2ChoiceType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2CountryType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2DocumentType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2EntityType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2HiddenType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2LanguageType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2LocaleType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2ModelType;
use Admingenerator\FormExtensionsBundle\Form\Type\Select2TimezoneType;
use Admingenerator\FormExtensionsBundle\Form\Type\SingleUploadType;
use Admingenerator\FormExtensionsBundle\Form\Type\TimePickerType;
use Admingenerator\FormExtensionsBundle\Form\Type\UploadCollectionType;
use Admingenerator\FormExtensionsBundle\Storage\LocalFileStorage;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $container->parameters()->set('admingenerator.form.upload_collection_listener.class', UploadCollectionListener::class);

    $services = $container->services();
    $configureFormType = static fn(string $id, string $class) => $services->set($id, $class)->tag('form.type');
    $configureFormType('admingenerator.form.extensions.type.bootstrap_table_collection', BootstrapTableCollectionType::class);
    $configureFormType('admingenerator.form.extensions.type.bootstrap_fieldset_collection', BootstrapFieldsetCollectionType::class);
    $configureFormType('admingenerator.form.extensions.type.bootstrap_money', MoneyType::class);
    $configureFormType('admingenerator.form.extensions.type.upload_collection', UploadCollectionType::class);
    $configureFormType('admingenerator.form.extensions.type.datetime_picker', DateTimePickerType::class);
    $configureFormType('admingenerator.form.extensions.type.daterange_picker', DateRangePickerType::class)
        ->call('setTranslator', [service('translator')]);
    $configureFormType('admingenerator.form.extensions.type.date_picker', DatePickerType::class);
    $configureFormType('admingenerator.form.extensions.type.double_list_entity', DoubleListEntityType::class);
    $configureFormType('admingenerator.form.extensions.type.double_list_document', DoubleListDocumentType::class);
    $configureFormType('admingenerator.form.extensions.type.double_list_model', DoubleListModelType::class);
    $configureFormType('admingenerator.form.extensions.type.elastic_textarea', ElasticTextareaType::class);
    $configureFormType('admingenerator.form.extensions.type.google_map', GoogleMapType::class);
    $configureFormType('admingenerator.form.extensions.type.knob', KnobType::class);
    $configureFormType('admingenerator.form.extensions.type.mini_colors', MiniColorsType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_entity', Select2EntityType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_document', Select2DocumentType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_model', Select2ModelType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_locale', Select2LocaleType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_language', Select2LanguageType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_country', Select2CountryType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_timezone', Select2TimezoneType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_choice', Select2ChoiceType::class);
    $configureFormType('admingenerator.form.extensions.type.single_upload', SingleUploadType::class);
    $configureFormType('admingenerator.form.extensions.type.time_picker', TimePickerType::class);
    $configureFormType('admingenerator.form.extensions.type.select2_hidden', Select2HiddenType::class);

    $services->set('admingenerator.form.file_storage.local', LocalFileStorage::class)
        ->arg('$requestStack', service('request_stack'));
};
