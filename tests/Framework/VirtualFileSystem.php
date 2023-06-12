<?php

/**
 * LICENSE: The MIT License (the "License")
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * https://github.com/azure/azure-storage-php/LICENSE
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * PHP version 5
 *
 * @see      https://github.com/azure/azure-storage-php
 */

namespace MicrosoftAzure\Storage\Tests\Framework;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStreamWrapper;

/**
 * Represents virtual file system for testing purpose.
 *
 * @see      https://github.com/azure/azure-storage-php
 */
class VirtualFileSystem
{
    public static function newFile($contents, $fileName = null, $root = null)
    {
        $root = null === $root ? 'root' : $root;
        $fileName = null === $fileName ? 'test.txt' : $fileName;

        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory($root));

        $file = vfsStream::newFile($fileName);
        $file->setContent($contents);

        vfsStreamWrapper::getRoot()->addChild($file);
        return vfsStream::url($root . '/' . $fileName);
    }
}
