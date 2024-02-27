# Mundo Wap CakePHP Test Application for Juniors

## Installation and access

To make this easier, all the commands necessary to install, run and access the application can be done through the `exec.sh` file in the project root, so if you intend to use it, you must ensure that it is executable typing the `chmod +x exec.sh` command.

Follow the steps bellow:

1. Create the `.env.app` and the `.env.db` files according to the related `.env.*.example` files executing the below command:
    ```bash
    ./exec.sh build-env
    ```
   or you can simply copy and rename the example files.
2. Build the docker image and install the application dependencies with the below command:
    ```bash
    ./exec.sh install
    ```
3. You may need to enter the application command line to execute migrations or install composer packages, to do this, execute the below command:
    ```bash
    ./exec.sh install app bash
    ```
4. Once in the application command line, execute the below command to exit:
    ```bash
    exit
    ```
5. Execute the below command to start the application:
    ```bash
    ./exec.sh start
    ```
6. Execute the below command to stop the application:
    ```bash
    ./exec.sh stop
    ```

After installed and started, the application should be accessible at `http://localhost:13001` and the database should be accessible at `http://localhost:3306`.

## Important instructions
Skills with containers and environment management are not the focus of this test, so in case of any issues creating, starting or executing the environment, please contact us.

The database structure should be created according to the `db_structure.sql` file.

Click [here](https://bit.ly/MWDevTestPHP) to see the test specifications, requirements and instructions.

### Authentication
If your implementation does not use CSRF authentication, you should remove the `Cake\Http\Middleware\CsrfProtectionMiddleware` at the `App\Application::middleware` method.

### Configure XDebug (optional)
Set the `XDEBUG_SESSION` key at the request cookies.

At your IDE, point the `app` project directory to the `/var/www/html` absolute path on server.
