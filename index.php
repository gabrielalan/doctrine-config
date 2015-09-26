<?php

// replace with file to your own project bootstrap
require_once 'bootstrap.php';

use Entities\Product;
use Entities\Bug;
use Entities\User;

echo '<pre>';

// $product = new Product();
// $product->setName('DBAL');

// $entityManager->persist($product);
// $entityManager->flush();

// echo "Created Product with ID " . $product->getId() . "\n";

// $productRepository = $entityManager->getRepository('Entities\Product');
// $products = $productRepository->findAll();

// foreach ($products as $product) {
//     echo sprintf("-%s\n", $product->getName());
// }

// $user = new User();
// $user->setName('Gabriel');

// $entityManager->persist($user);
// $entityManager->flush();

// echo "Created User with ID " . $user->getId() . "\n";

// $productIds = array(1,2);

// $reporter = $entityManager->find("Entities\User", 3);
// $engineer = $entityManager->find("Entities\User", 2);

// if (!$reporter || !$engineer) {
//     echo "No reporter and/or engineer found for the input.\n";
//     exit(1);
// }

// $bug = new Bug();
// $bug->setDescription("Something does not work!");
// $bug->setCreated(new DateTime("now"));
// $bug->setStatus("OPEN");

// foreach ($productIds as $productId) {
//     $product = $entityManager->find("Entities\Product", $productId);
//     $bug->assignToProduct($product);
// }

// $bug->setReporter($reporter);
// $bug->setEngineer($engineer);

// $entityManager->persist($bug);
// $entityManager->flush();

// echo "Your new Bug Id: ".$bug->getId()."\n";

$dql = "SELECT partial b.{id,description}, e, r FROM Entities\Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";

$query = $entityManager->createQuery($dql);
$query->setMaxResults(30);
$bugs = $query->getArrayResult();

echo (json_encode($bugs));

// foreach ($bugs as $bug) {
//     echo $bug->getDescription()." - ".$bug->getCreated()->format('d.m.Y')."\n";
//     echo "    Reported by: ".$bug->getReporter()->getName()."\n";
//     echo "    Assigned to: ".$bug->getEngineer()->getName()."\n";
//     foreach ($bug->getProducts() as $product) {
//         echo "    Platform: ".$product->getName()."\n";
//     }
//     echo "\n";
// }

// $conn = $entityManager->getConnection();

// $stmt = $conn->query('select * from products');

// var_dump($stmt->getArrayResult());

// $bugs = $entityManager->getRepository('Entities\Bug')->getRecentBugs();

// foreach ($bugs as $bug) {
//     echo $bug->getDescription()." - ".$bug->getCreated()->format('d.m.Y')."\n";
//     echo "    Reported by: ".$bug->getReporter()->getName()."\n";
//     echo "    Assigned to: ".$bug->getEngineer()->getName()."\n";
//     foreach ($bug->getProducts() as $product) {
//         echo "    Platform: ".$product->getName()."\n";
//     }
//     echo "\n";
// }