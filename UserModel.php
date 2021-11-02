<?php

namespace jesterone\mvccore;

use jesterone\mvccore\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}