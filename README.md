# PHP Atuin framework

PHP Atuin is a web application skeleton from which to start to develop projects 
that require high performances, modularity, good maintainability of the code and
great scalability.

This repo contains the PHP version of the [Scalebox]'s [Flask Atuin] web 
application skeleton.


## Requirements

- docker-compose


## Features included

- CSS and JavaScript files concatenation and minification (+ obfuscation)
- SASS preprocessor
- Image optimization
- Template engine for dynamic composition of templates and templates' hierarchies
- Routing engine for dynamic URLs creation 

## Launch development environment

```bash
    docker-compose up
```

## Gulp tasks

Atuin Gulp's tasks can be run within [atuin-gulp] docker container.


## Atuin conventions

- CSS

    - `.<regularApplicationCSSClass>`
    - `.btnSave<EntityName>`
    - `.btnNew<EntityName>`

- JS
    
    - `bind<FunctionalModuleName>` 
    - `bind<FunctionalModuleName>Admin` 

- Template names

    - `form_<name>.php`
    - `modal_<name>.php`

## TODO

- Users management
- Translations
- Routing improvement
- Authentication abstractions
- Cache abstractions

[SCALEBOX]: http://www.scalebox.it/
[Flask Atuin]: https://github.com/atuinframework/flask-atuin
[atuin-gulp]: https://github.com/atuinframework/atuin-gulp
