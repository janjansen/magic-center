<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 10/28/15
 * Time: 4:39 PM
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Knp\Menu\ItemInterface as MenuItemInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
/**
 * Class BaseAdmin
 * @package AppBundle\Admin
 */
class BaseAdmin extends Admin
{
    const DATETIME_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    /**
     * @return \AppBundle\Entity\Admin
     */
    public function getCurrentUser()
    {
        return $this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser();
    }

    protected function configureTabMenu(MenuItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
//        $menu->addChild('фильтры', ['uri'=> '#','attributes'=>['id'=>'showFilter']]);
    }
}