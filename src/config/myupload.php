<?php

return [
    'title' => getenv('MYUPLOAD_TITLE','My Upload'),
    'subtitle' => getenv('MYUPLOAD_SUBTITLE','Help us document and preserve history.'),
    'submit_step_text' => getenv('MYUPLOAD_SUBMIT_STEP','We will review your submission and let you know when it is approved.'),
    'wanted_items_text' => getenv('MYUPLOAD_WANTED_ITEMS','We are looking for photographs, documents and audiovisual materials that tell the stories of our community. Our most wanted subjects are:'),
    'copyright_disabled' => getenv('MYUPLOAD_COPYRIGHT_DISABLED',false),
    'thankyou' => getenv('MYUPLOAD_THANKYOU','Your item has been uploaded. You will receive an email when your item is loaded.'),
];
