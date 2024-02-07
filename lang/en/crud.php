<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'courses' => [
        'name' => 'Courses',
        'index_title' => 'Courses List',
        'new_title' => 'New Course',
        'create_title' => 'Create Course',
        'edit_title' => 'Edit Course',
        'show_title' => 'Show Course',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'user_id' => 'User',
        ],
    ],

    'sections' => [
        'name' => 'Sections',
        'index_title' => 'Sections List',
        'new_title' => 'New Section',
        'create_title' => 'Create Section',
        'edit_title' => 'Edit Section',
        'show_title' => 'Show Section',
        'inputs' => [
            'name' => 'Name',
            'description' => 'Description',
            'course_id' => 'Course',
            'user_id' => 'User',
        ],
    ],

    'topics' => [
        'name' => 'Topics',
        'index_title' => 'Topics List',
        'new_title' => 'New Topic',
        'create_title' => 'Create Topic',
        'edit_title' => 'Edit Topic',
        'show_title' => 'Show Topic',
        'inputs' => [
            'title' => 'Title',
            'prompt' => 'Prompt',
            'json' => 'Json',
            'html' => 'Html',
            'complete' => 'Complete',
            'section_id' => 'Section',
            'course_id' => 'Course',
            'user_id' => 'User',
        ],
    ],

    'histories' => [
        'name' => 'Histories',
        'index_title' => 'Histories List',
        'new_title' => 'New History',
        'create_title' => 'Create History',
        'edit_title' => 'Edit History',
        'show_title' => 'Show History',
        'inputs' => [
            'prompt' => 'Prompt',
            'json' => 'Json',
            'topic_id' => 'Topic',
            'section_id' => 'Section',
            'course_id' => 'Course',
            'user_id' => 'User',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];
