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

namespace oat\taoTalk\model;

use common_session_SessionManager;
use core_kernel_classes_Resource;
use core_kernel_classes_Class;
use core_kernel_classes_Property;
use tao_helpers_Date;

class GenerisComment
{
    const CLASS_GENERIS_COMMENT = 'http://www.tao.lu/Ontologies/generis.rdf#comment';
    
    const PROPERTY_GENERIS_RESOURCE_COMMENT = 'http://www.tao.lu/Ontologies/generis.rdf#generisRessourceComment';
    
    const PROPERTY_COMMENT_AUTHOR = 'http://www.tao.lu/Ontologies/generis.rdf#commentAuthor';
    
    const PROPERTY_COMMENT_TIMESTAMP = 'http://www.tao.lu/Ontologies/generis.rdf#commentTimestamp';
    
    public static function getCommentData(core_kernel_classes_Resource $resource) {

        $commentUris = $resource->getPropertyValues(new core_kernel_classes_Property(self::PROPERTY_GENERIS_RESOURCE_COMMENT));
        
        $commentData = array();
        foreach ($commentUris as $uri) {
            $comment = new core_kernel_classes_Resource($uri);
            $props = $comment->getPropertiesValues(array(
                RDF_VALUE, self::PROPERTY_COMMENT_AUTHOR, self::PROPERTY_COMMENT_TIMESTAMP
            ));
            $author = current($props[self::PROPERTY_COMMENT_AUTHOR]);
            $date = current($props[self::PROPERTY_COMMENT_TIMESTAMP]);
            $text = (string)current($props[RDF_VALUE]);
            $commentData[(string)$date] = array(
                'author' => $author->getLabel(),
                'date' => tao_helpers_Date::displayeDate((string)$date),
                'text' => _dh($text)
            );
             
            ksort($commentData);
        }
        return $commentData;
    }
    
    public static function addComment(core_kernel_classes_Resource $resource, $text) {
        $commentClass = new core_kernel_classes_Class(self::CLASS_GENERIS_COMMENT);
        $time = time();
        $authorId = common_session_SessionManager::getSession()->getUser()->getIdentifier();
        
        $comment = $commentClass->createInstanceWithProperties(array(
            RDF_VALUE                           => $text,
            self::PROPERTY_COMMENT_AUTHOR       => $authorId,
            self::PROPERTY_COMMENT_TIMESTAMP    => $time
        ));
        
        $resource->setPropertyValue(new core_kernel_classes_Property(self::PROPERTY_GENERIS_RESOURCE_COMMENT), $comment);
        
        return $comment;
    }
}