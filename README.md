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

php bin/magento cache:enable  - to make it faster
php bin/magento setup:upgrade
php bin/magento cache:flush
php bin/magento indexer:reindex

php bin/magento cron:remove
php bin/magento cron:install

php bin/magento cache:flush && php bin/magento cache:clean
php bin/magento setup:di:compile
crontab -l

php bin/magento cron:run --group="subscription"