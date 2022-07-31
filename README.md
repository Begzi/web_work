php 7.3.26, Composer 2.0.14. Есть пользователь TZI1 Z123456z
![image](https://user-images.githubusercontent.com/49578823/182028353-64561757-459b-4304-a42b-4d347e8e3e0a.png)

CRM сайт для компании в котором я работал. ТЗ от компании в файле "ТЗ для сайта".

25 таблиц, в mySql
auth_item
auth_item_child
migration
customer
    address
        region
    contact
        contact_position
    doc_type 
    scheme
log_ticket_list  
    log_ticket_priority
    log_ticket_type
    kbase_list
    log_event
    lws_user
cert
    cert_group_name
    mail
    mail_base    
cert_uz (для связи многое ко многим, для cert и uz_list)
uz_list
    net_list
    uz_type
    uz_type_categoria
![image](https://user-images.githubusercontent.com/49578823/182027744-32943634-8e6a-43ca-90c5-5dca4ed1faa6.png)

15 контроллеров, где BaseController является родительским всем остальным. Сделано это для того, чтобы раз в день проверять, не истёк ли срок действия сертификата у заказчика (кеширование).
14 папок для VIEW, по факту 25 страниц для пользователя. + модальные окна в парочке страниц.
39 моделей, 25 из них для таблиц, остальные 14 - это формы для ввода данных от пользователя. 
JS не выделил отдельно в файл JS, так как посчитал это не целесообразным, большинство кода JS предназначенна для одной страницы. К примеру analyze/index.php и customer/view.php для класса according 
CSS от Bootstrap скопировал из сети и использовал те классы, которые описаны в CSS.


