<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/contact.php";

    session_start();
    if (empty($_SESSION['list_of_contacts'])) {
        $_SESSION['list_of_contacts'] = array();
    }

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__."/../views"

    ));

    $app->get("/", function() use ($app) {

      return $app['twig']->render('create_contacts.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/create_contacts", function() use ($app) {
        $contact = new Contact($_POST['name'], $_POST['address'], $_POST['number']);
        $contact->save();
        return $app['twig']->render('show_contact.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/delete_contacts", function() use ($app) {
        Contact::deleteAll();
        return $app['twig']->render('show_contact.html.twig', array('contacts' => Contact::getAll()));
    });

    return $app;
?>
