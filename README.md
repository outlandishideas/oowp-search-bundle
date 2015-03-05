Oowp Search Bundle
========================

Symfony 2 Bundle to be used with the Wordpress enabled Symfony 2 using the [RoutemasterBundle](https://github.com/outlandishideas/RoutemasterBundle)
and the [OowpBundle](https://github.com/outlandishideas/OowpBundle). 

It provides a number of custom Form Types and an EventSubscriber to turn the data inputted into a form into 
the arguments for a [Wordpress Query](http://wordpress.org/wp_query) object. This can be used to create a
faceted search interface using the Symfony 2 Form components. 

## Features

* Form Field Type for the `post_type` argument.
* Form Field Type for standard search query arguments such as `order`, `orderby`.
* Form Field Type for use with Post To Post relationships. It produces `connected_type` and `connected_items` arguments.
* Form Field Type for custom fields. It produces `meta_query` arguments.
* An EventSubscriber to 

## Installation

* Add the github repository `https://github.com/outlandishideas/OowpSearchBundle.git` to the repositories section of your composer.json file
* Run `composer require outlandish/oowp-search-bundle` (assuming [Composer](http://getcomposer.org/download/) is installed globally).
* Enable the Symfony 2 form component in your config.yml file.

## Usage

Using the components of this bundle requires a good knowledge of the Form Component in Symfony 2. 

### Creating the form in your controller

### Creating the form as a service

Create a new class that extends `Outlandish\OowpSearchBundle\Form\Type\WPQueryType`. Implement the getName() method, and
override the `buildForm()` method to build up your form's fields. Ensure that you call the parent implementation of this 
method to add the `Outlandish\OowpSearchBundle\Form`EventSubscriber\WPFormEventSubscriber` as an Event Subscriber.

Implement this class as a Form service. You will then be able to create this particular form in your controller
using the below excerpt. 

### Using the form in the controller

To use the form's data in your controller and use it to fetch Wordpress posts from the database, call the 
`handleRequest` method on the form. This will populate the data of the form using the data from the request
and call the EventSubscriber to parse this request data correctly. 

Then simply call the `getData` method on the form object to get the array of arguments to be passed through when 
instantiating the WP_Query object. 

You can display the form on the page in the same way as all Symfony 2 forms are so displayed. For more information 
see the Symfony 2 documentation for the Form Component