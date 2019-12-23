# subscription

1. Product attribute - subscription is created - setup script
2. For all orders which have the product attribute - subscription(enabled/disabled) a quote will be created
3. subscription table :
    * id 
    * customer_id
    * quote_id
    * scheduled_at
    * created_at
    * updated_at
4. a cronjob will run to create from quotes orders

composer update atty31/subscription

bin/magento cache:enable  - to make it faster
bin/magento setup:upgrade
bin/magento cache:flush
bin/magento indexer:reindex

bin/magento cron:remove
bin/magento cron:install

bin/magento cache:flush && php bin/magento cache:clean
bin/magento setup:di:compile
crontab -l

bin/magento cron:run --group="subscription"




$writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
$logger = new \Zend\Log\Logger();
$logger->addWriter($writer);
$logger->info("{$this->shippingMethodId}");


6fbc33b46798431baa81c38af2b595b4
665f0f2eabec714849c5cc82ab580760