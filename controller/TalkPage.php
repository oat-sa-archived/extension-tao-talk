<?php
/**  
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 * Copyright (c) 2014 (original work) Open Assessment Technologies SA;
 *               
 * 
 */

namespace oat\taoTalk\controller;

use tao_helpers_Request;
use tao_helpers_Uri;
use common_exception_MissingParameter;
use core_kernel_classes_Resource;
use core_kernel_classes_Property;
use oat\taoTalk\model\GenerisComment;

/**
 * Controller to manage the Talk (discussion) page
 *
 * @author Open Assessment Technologies SA
 * @package taoTalk
 * @license GPL-2.0
 *
 */
class TalkPage extends \tao_actions_CommonModule {

    /**
     * initialize the services
     */
    public function __construct(){
        parent::__construct();
    }

    protected function getCurrentInstance()
    {
        $uri = null;
        if ($this->hasRequestParameter('uri')) {
            $uri = tao_helpers_Uri::decode($this->getRequestParameter('uri'));
        }
        if (empty($uri) && $this->hasRequestParameter('classUri')) {
            $uri = tao_helpers_Uri::decode($this->getRequestParameter('classUri'));
        }
        if(is_null($uri) || empty($uri)){
            throw new common_exception_MissingParameter("uri", __CLASS__);
        }
        return new core_kernel_classes_Resource($uri);
    }
    
    /**
     * get the meta data of the selected resource
     * Display the metadata.
     * @return void
     */
    public function index()
    {
        if(!tao_helpers_Request::isAjax()){
            throw new Exception("wrong request mode");
        }
        
        $instance = $this->getCurrentInstance();
        
        $this->setData('comments',	GenerisComment::getCommentData($instance));
        $this->setData('uri',		$instance->getUri());
        $this->setData('metadata',	true);
    
        $this->setView('TalkPage/index.tpl', 'taoTalk');
    }
    
    /**
     * save the comment field of the selected resource
     * @return json response {saved: true, comment: text of the comment to refresh it}
     */
    public function saveMetaData()
    {
        if(!tao_helpers_Request::isAjax()){
            throw new Exception("wrong request mode");
        }
        
        $resource = $this->getCurrentInstance();
        $text = $this->getRequestParameter('comment');
        
        $comment = GenerisComment::addComment($resource, $text);
        
        $authorLabel = \common_session_SessionManager::getSession()->getUserLabel();
        echo json_encode(array(
            'saved' 	=> true,
            'author'    => $authorLabel,
            'date'      => \tao_helpers_Date::displayeDate((string)time()),
            'text' 	    => $text
        ));
    }
}