<?php

declare(strict_types = 1);

namespace Practice\Unit1\Controller;

use Magento\Framework\App\Action\Forward;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var ActionFactory
     */
    private ActionFactory $actionFactory;

    /**
     * Router constructor.
     *
     * @param ActionFactory $actionFactory
     */
    public function __construct(
        ActionFactory $actionFactory
    ) {
        $this->actionFactory = $actionFactory;
    }

    /**
     * Match the route.
     *
     * @param RequestInterface $request
     * @return ActionInterface|null
     */
    public function match(RequestInterface $request): ?ActionInterface /** @phpstan-ignore-line */
    {
        /** @phpstan-ignore-next-line */
        $identifier = trim($request->getPathInfo(), '/');

        if (str_contains($identifier, 'practice')) {
            $request->setModuleName('unit1');
            $request->setControllerName('index'); /** @phpstan-ignore-line */
            $request->setActionName('index');
            return $this->actionFactory->create(Forward::class);
        }

        return null;
    }
}
