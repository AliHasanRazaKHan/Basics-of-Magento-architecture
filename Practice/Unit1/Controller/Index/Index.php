<?php

declare(strict_types = 1);

namespace Practice\Unit1\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Area;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\Store;
use Psr\Log\LoggerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Practice\Unit1\Helper\Data;

class Index implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private PageFactory $pageFactory;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var StateInterface
     */
    private StateInterface $inlineTranslation;

    /**
     * @var TransportBuilder
     */
    private TransportBuilder $transportBuilder;

    /**
     * @var Data
     */
    private Data $helper;

    /**
     * @var SenderResolverInterface
     */
    private SenderResolverInterface $senderResolver;

    /**
     * @param PageFactory $pageFactory
     * @param LoggerInterface $logger
     * @param StateInterface $inlineTranslation
     * @param TransportBuilder $transportBuilder
     * @param Data $helper
     * @param SenderResolverInterface $senderResolver
     */
    public function __construct(
        PageFactory             $pageFactory,
        LoggerInterface         $logger,
        StateInterface          $inlineTranslation,
        TransportBuilder        $transportBuilder,
        Data                    $helper,
        SenderResolverInterface $senderResolver
    ) {
        $this->pageFactory = $pageFactory;
        $this->logger = $logger;
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->helper = $helper;
        $this->senderResolver = $senderResolver;
    }

    /**
     * Return page.
     *
     * @return Page
     */
    public function execute(): Page
    {
        // Trigger logging; see di.xml for logger override
        $this->logger->error('practice.error');
        $this->logger->info('practice.info');
        $this->logger->critical('practice.critical');
        $this->logger->debug('practice.debug');
        $this->logger->alert('practice.alert');
        $this->logger->notice('practice.notice');
        $this->logger->warning('practice.warning');

        try {

            $this->inlineTranslation->suspend();

            $sender = $this->senderResolver->resolve($this->helper->getSenderEmailIdentity());

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($this->helper->getEmailTemplate())
                ->setTemplateOptions(
                    [
                        'area' => Area::AREA_FRONTEND,
                        'store' => Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars([
                    'var1' => 'Val 1',
                    'var2' => 'Val 2',
                ])
                ->setFromByScope($sender)
                ->addTo($this->helper->getRecipientEmail(), 'Unit1')
                ->getTransport();

            $transport->sendMessage();

            $this->inlineTranslation->resume();
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }

        // Render the page with title, see view/frontend/layout/unit1_index_index.xml
        // We do not need any *.phtml files here, this is just a practice.
        return $this->pageFactory->create();
    }
}
