<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.3.4
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

/**
 * Error Handling Controller
 *
 * Controller used by ExceptionRenderer to render error responses.
 */
class ErrorController extends AppController
{
    /**
     * Initialization hook method.
     *
     * @return void
     */
    public function initialize(): void
    {
        $this->loadComponent('RequestHandler', ['enableBeforeRedirect' => false]);
    }

    /**
     * beforeRender callback.
     *
     * Called after the methods in the controllers are ran, but before the template is rendered.
     *
     * @param \Cake\Event\Event<mixed> $event Event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(\Cake\Event\EventInterface $event)
    {
        $this->viewBuilder()->setTemplatePath('Error');

        return parent::beforeRender($event);
    }
}
