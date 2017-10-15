<?php

namespace Importers;

/**
 * Abstract base class to hang some OO logic around
 * Doesn't do anything else other than act as a sensible name base
 * This gives me a meaningful guarantee that my classes extend
 * the correct core filereader code, and implement the same interface
 */
abstract class Base extends \Lib\FileReader implements ImporterInterface {

}
