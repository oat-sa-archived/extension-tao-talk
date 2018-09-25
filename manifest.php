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

return array(
    'name' => 'taoTalk',
	'label' => 'Talk Pages',
	'description' => 'Allows discussions about resources',
    'license' => 'GPL-2.0',
    'version' => '0.9.1',
	'author' => 'Open Assessment Technologies SA',
	'requires' => array('tao' => '>=2.6'),
	// for compatibility
	'dependencies' => array('tao'),
	'managementRole' => 'http://www.tao.lu/Ontologies/generis.rdf#taoTalkManager',
    'acl' => array(
        array('grant', 'http://www.tao.lu/Ontologies/generis.rdf#taoTalkManager', array('ext'=>'taoTalk')),
    ),
    'uninstall' => array(
    ),
    'autoload' => array (
        'psr-4' => array(
            'oat\\taoTalk\\' => dirname(__FILE__).DIRECTORY_SEPARATOR
        )
    ),
    'routes' => array(
        '/taoTalk' => 'oat\\taoTalk\\controller'
    ),
    'update' => 'oat\\taoTalk\\scripts\\update\\Updater',
	'constants' => array(
	    # views directory
	    "DIR_VIEWS" => dirname(__FILE__).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR,
	    
		#BASE URL (usually the domain root)
		'BASE_URL' => ROOT_URL.'taoTalk/',
	    
	    #BASE WWW required by JS
	    'BASE_WWW' => ROOT_URL.'taoTalk/views/'
	),
    'extra' => array(
        'structures' => dirname(__FILE__).DIRECTORY_SEPARATOR.'controller'.DIRECTORY_SEPARATOR.'structures.xml',
    )
);