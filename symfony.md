#SYMFONY

## Create Project : 

1. Install Composer :

    ```shell
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
        php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
        php composer-setup.php
        php -r "unlink('composer-setup.php');"
    ```
    Set it to be Global :
    
    ```shell
    mv composer.phar /usr/local/bin/composer
    ```
2. Source Files
    
    ```shell
    composer create-project symfony/website-skeleton [LOCATION]
    ```
3. Local Server (tests)

    ```shell
    composer require server --dev
    ```
    
    In the project folder :
    * Interactive Mode :
    ```shell
    php bin/console server:run
    ```
## Usefull Dependancies
1. annotations => 
2. doctrine maker =>
3. form =>
4. validator =>
5. mailer =>

    Install : 
    ```shell
    composer require annotations doctrine maker [...]
    ```       
## Controllers & Routes    
1. Controller : 

    Exemple simple: 
    ```php
    namespace App\Controller;
    
    
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route ;
    
    class Home extends Controller
    {
        /**
         * @Route ("/", name="home")
         */
        public function home()
        {
            return $this->render("base.html.twig");
        }
    }
    ```
2. Create via terminal : 

    ```shell
    php bin/console make:controller
    ```