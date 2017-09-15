## Project's JavaScript files

These JavaScript files will be minified and optimized to speed up page loading
leveraging browser's cache.

Attention: **public scripts** are distinguished from **admin scripts**


### Create a script file for one section

For each website's section two files should be created, better if they have the
same name of the section. Place the public file in `app/static/src/js` and the
admin one in `static/src/js/admin`.

The files should have the structure:

```javascript
window.bindSectionName = function() {
    /* All the code for this section goes here... */
};

window.bindAdminSectionName = function() { };
```

Then add the relative init functions to the respective `main.js` files. 

Public scripts activation calls: `static/src/js/main.js`.
Admin scripts activation calls: `static/src/js/admin/main.js`.

```javascript
$(function() {
	$('html.section_name').each(function () {
        bindSectionName();
    });
});

$(function() {
	$('html.admin.section_name').each(function () {
        bindAdminSectionName();
    });
});
```

### Destinations

The total, concatenated and minified JavaScript files are at:

- `/static/min/js/all.js` **public scripts**. The directory containing the 
scripts is public.
- `/static/min/js/admin/all.js` **admin scripts**. This directory containing the
scripts for the admin area could be secured through deployment of web server 
configuration.
