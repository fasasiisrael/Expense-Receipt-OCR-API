<?php
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controller\ReceiptController;
use Psr\Container\ContainerInterface;

// Define routes for receipt management
$app->post('/addReceipt', function (Request $request, Response $response, $args) {
    $imagePath = $request->getParsedBody()['imagePath'];
    
    /** @var ReceiptController $receiptController */
    $receiptController = $this->get(ReceiptController::class);
    $result = $receiptController->addReceipt($imagePath);

    return $response->withJson($result);
});

$app->get('/getAllReceipts', function (Request $request, Response $response, $args) {
    /** @var ReceiptController $receiptController */
    $receiptController = $this->get(ReceiptController::class);
    $receipts = $receiptController->getAllReceipts();

    return $response->withJson($receipts);
});

// Add other routes as needed

// Dependency injection for ReceiptController
$container = $app->getContainer();

$container[ReceiptController::class] = function (ContainerInterface $container) {
    // You may adjust the constructor parameters based on your ReceiptController
    return new ReceiptController();
};
