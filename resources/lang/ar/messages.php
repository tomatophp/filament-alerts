<?php

return [
    'group' => 'الإعدادات',
    'back' => 'رجوع',
    'actions' => [
        'send' => [
            'label' => 'إرسال التنبيه',
            'form' => [
                'template_id' => 'القالب',
                'model_id' => 'المستخدم',
                'model_type' => 'نوع المستخدم',
                'privacy' => 'الخصوصية',
                'public' => 'عام',
                'private' => 'خاص',
            ],
            'notification' => 'تم إرسال التنبيه',
        ],
    ],
    'templates' => [
        'title' => 'التنبيهات',
        'single' => 'قالب',
        'create' => 'إنشاء قالب',
        'edit' => 'تعديل قالب',
        'actions' => [
            'clone' => 'تكرار',
            'try' => 'تجربة',
            'clone-notification' => 'تم تكرار القالب بنجاح',
            'try-notification' => 'تم ارسال القالب بنجاح',
            'try-notification-danger' => 'عفواً حديث خطا اثناء تجربة القالب',
        ],
        'form' => [
            'image' => 'الصورة',
            'name' => 'الاسم',
            'key' => 'المفتاح',
            'title' => 'العنوان',
            'body' => 'الرسالة',
            'url' => 'الرابط',
            'icon' => 'الايقونة',
            'providers' => 'المزودين',
            'type' => 'النوع',
            'action' => 'يتم ارساله بواسطة',
            'manual' => 'يدوي',
            'system' => 'النظام',
            'created_at' => 'تم إنشاءه في',
            'updated_at' => 'تم تحديثه في',
        ],
        'sections' => [
            'details' => [
                'title' => 'تفاصيل القالب',
                'description' => 'اسم القالب والمفتاح الفريد للوصول إلى القالب من الكود',
            ],
            'content' => [
                'title' => 'محتوى الإشعار',
                'description' => 'عنوان ورسالة الإشعار',
            ],
            'media' => [
                'title' => 'وسائط الإشعار والرابط',
                'description' => 'الصورة والرابط الذي سيتم توجيه المستخدم إليه',
            ],
        ],
    ],
    'logs' => [
        'title' => 'سجل التنبيهات',
        'description' => 'احصل على اخر السجلات الخاصة بعمليات التنبيهات',
        'form' => [
            'user' => 'المستخدم',
            'title' => 'العنوان',
            'type' => 'النوع',
            'provider' => 'المزود',
            'created_at' => 'تم إنشاءه في',
            'updated_at' => 'تم تحديثه في',
        ],
    ],
    'settings' => [
        'group' => 'التنبيهات',
        'email' => [
            'title' => 'إعدادات البريد الالكتروني',
            'description' => 'تحديث وربط البريد الالكتروني',
            'mail_mailer' => 'Mailer',
            'mail_host' => 'Host',
            'mail_port' => 'Port',
            'mail_username' => 'Username',
            'mail_password' => 'Password',
            'mail_encryption' => 'Encryption',
            'mail_from_address' => 'From address',
            'mail_from_name' => 'From Name',
        ],
    ],
];
