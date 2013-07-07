edmunds-php-api
===============

Collection of API resources for the Edmunds vehicle API(s).  The http client used
is Guzzle (http://guzzlephp.org).

Usage
===============

You will first need an API key.  You can go to http://developer.edmunds.com and apply for a
developer API key.  There are 4 different APIs that make up the entirety of the Edmunds API,
you will have to apply for a key for each.  I won't go into too much detail here about that
process.

In the simplest form, you can use it as follows:

    In your composer.json, add the following dependency (replace {version} with latest version):

        "rfink/edmunds-php-api": "{version}"

    Then run composer update from the command line.

    Inside your app, you can bootstrap the guzzle client by adding the following code:

        $vehicleClient = \RF\Edmunds\Vehicle\Client::factory(array(
            'api_key' => '{your_api_key_here}',
            'base_url' => 'http://api.edmunds.com'
        ));

    Then, you can run commands:

        $args = array('id' => '100533210');
        $command = $client->getCommand('modelYear.findById', $args);
        $response = $command->execute()->toArray();

    Response will contain a plain php array representing the API response payload.

The best way to see how this works in action is to take a peek at the unit tests, as well
as the API descriptions at the Edmunds developer website.  The service description JSON
files are also a good place to see required parameters for each call, and the response
format.

###### A symfony2 bundle is being developed to wrap this as a service as well, see https://github.com/rfink/EdmundsBundle

** This API is still in heavy, heavy alpha mode.  Use in production at your own risk.**