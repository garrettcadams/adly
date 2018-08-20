<?php
// http://book.cakephp.org/3.0/en/views/helpers/form.html#list-of-templates
return [
    'inputContainer' => '<div class="form-group {{type}} {{required}}">{{content}}</div>',
    'error' => '<span class="help-block">{{content}}</span>',
    'inputContainerError' => '<div class="form-group has-error {{type}} {{required}}">{{content}}{{error}}</div>'
];
