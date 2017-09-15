## Project's CSS files

These CSS files will be minified and optimized to speed up page loading by
leveraging the browser's cache.

Attention: **public css** are distinguished from **admin css**


### Create a CSS file for one section

For each website's section two files should be created, better if they have the
same name of the section. Place the public file in `app/static/src/css` and the
admin one in `static/src/css/admin`.

The files should have the structure:

```scss
html.section_name {
    /* All the code for this section goes here... */
}

html.admin.section_name { }
```

Then import the relative files in the respective `style.scss` files. 

> Use _variables.scss files to define public and admin SCSS variables.

### Destinations

The total, concatenated and minified CSS files are at:

- `/static/min/css/style.css` **public css**. The directory containing the 
css is public.
- `/static/min/css/admin/style.css` **admin css**. This directory containing
 the css for the admin area could be secured through deployment of web server 
configuration.
