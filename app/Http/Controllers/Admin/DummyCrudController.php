<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DummyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Str;

/**
 * Class DummyCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DummyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Dummy');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/dummy');
        $this->crud->setEntityNameStrings('dummy', 'dummies');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn('name');
        CRUD::addColumn('description');
        CRUD::addColumn([
            'name' => 'extras',
            'type' => 'array_count',
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(DummyRequest::class);
        $this->crud->setOperationSetting('contentClass', 'col-md-12');

        CRUD::addField('name');
        CRUD::addField('description');

        // Field Types: text, textarea
        $groups['question_and_answer'] = [
            [
              'name' => 'question',
              'label' => 'Question',
              'type' => 'textarea',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-6' ],
            ],
            [
              'name' => 'answer',
              'label' => 'Answer',
              'type' => 'textarea',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-6' ],
            ],
        ];

        // Field Types: text, textarea
        $groups['testimonials'] = [
            [
              'name' => 'name',
              'label' => 'Name',
              'type' => 'text',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-4' ],
            ],
            [
              'name' => 'position',
              'label' => 'Position',
              'type' => 'text',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-4' ],
            ],
            [
              'name' => 'company',
              'label' => 'Company',
              'type' => 'text',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-4' ],
            ],
            [
              'name' => 'quote',
              'label' => 'Quote',
              'type' => 'textarea',
            ],
        ];

        // Field Types: browse, text, checkbox
        $groups['attachments'] = [
            [   // Browse
                'name' => 'file',
                'label' => 'File',
                'type' => 'browse',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-5' ],
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'text',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-5' ],
            ],
            [   // Checkbox
                'name' => 'visible',
                'label' => 'Visible',
                'type' => 'checkbox',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-2 pt-4' ],
            ]
        ];

        // Field Types: select, color
        $groups['related_categories'] = [
            [  // Select
                'label' => "Category",
                'type' => 'select',
                'name' => 'category_id', // the db column for the foreign key
                'entity' => 'categories', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'model' => \Backpack\NewsCRUD\app\Models\Category::class,
                'wrapperAttributes' => [ 'class' => 'form-group col-md-9' ],
            ],
            [   // Color
                'name' => 'background_color',
                'label' => 'Background Color',
                'type' => 'color',
                'default' => '#000000',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-3' ],
            ]
        ];

        // Field Types: select2, color_picker
        $groups['related_categories_second'] = [
            [  // Select
                'label' => "Categories",
                'type' => 'select2',
                'name' => 'categories', // the method that defines the relationship in your Model
                'entity' => 'categories', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'model' => \Backpack\NewsCRUD\app\Models\Category::class, // foreign key model
                'wrapperAttributes' => [ 'class' => 'form-group col-md-9' ],
            ],
            [   // Color
                'name' => 'background_color',
                'label' => 'Background Color',
                'type' => 'color_picker',
                'default' => '#000000',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-3' ],
            ]
        ];

        // Field Types: select_multiple, date
        $groups['scheduled_categories'] = [
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label' => "Categories",
                'type' => 'select_multiple',
                'name' => 'categories', // the method that defines the relationship in your Model
                'entity' => 'categories', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'model' => \Backpack\NewsCRUD\app\Models\Category::class, // foreign key model
                'wrapperAttributes' => [ 'class' => 'form-group col-md-9' ],
            ],
            [   // Date
                'name' => 'publish_date',
                'label' => 'Publish Date',
                'type' => 'date',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-3' ],
            ]
        ];

        // Field Types: select2_multiple, date_picker
        $groups['scheduled_categories_second'] = [
            [   // SelectMultiple = n-n relationship (with pivot table)
                'label' => "Categories",
                'type' => 'select2_multiple',
                'name' => 'categories', // the method that defines the relationship in your Model
                'entity' => 'categories', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                // 'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
                'model' => \Backpack\NewsCRUD\app\Models\Category::class, // foreign key model
                'wrapperAttributes' => [ 'class' => 'form-group col-md-9' ],
            ],
            [   // Date
                'name' => 'publish_date',
                'label' => 'Publish Date',
                'type' => 'date_picker',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-3' ],
            ]
        ];

        // Field Types: number, date_range, custom_html
        $groups['holidays'] = [
            [
              'name' => 'number',
              'label' => 'Holiday Number',
              'type' => 'number',
              'wrapperAttributes' => [ 'class' => 'form-group col-md-2' ],
            ],
            [ // Date_range
                'name'       => ['start_date', 'end_date'], // a unique name for this field
                'label'      => 'Holiday Timeframe',
                'type'       => 'date_range',
                'default'    => ['2020-03-28 01:01', '2020-04-05 02:00'],
                // OPTIONALS
                // 'date_range_options' => [ // options sent to daterangepicker.js
                //     'timePicker' => true,
                //     'locale'     => ['format' => 'DD/MM/YYYY HH:mm'],
                // ],
                'wrapperAttributes' => [ 'class' => 'form-group col-md-8' ],
            ],
            [   // CustomHTML
                'name' => 'separator',
                'type' => 'custom_html',
                'value' => '<br><strong>Some</strong>thing <i>else</i>',
                'wrapperAttributes' => [ 'class' => 'form-group col-md-2' ],
            ]
        ];

        foreach ($groups as $groupKey => $groupFields) {
            CRUD::addField([
                'name' => $groupKey,
                'label' => str_replace('_', ' ', Str::title($groupKey)),
                'type' => 'repeatable',
                'fake' => true,
                'store_in' => 'extras',
                'fields' => $groupFields,
            ]);
        }
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->setupListOperation();
        
        CRUD::addColumn([
            'name' => 'created_at',
            'type' => 'datetime',
        ]);
        CRUD::addColumn([
            'name' => 'updated_at',
            'type' => 'datetime',
        ]);
    }


}
