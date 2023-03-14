<?php

namespace Netflex\DBAL\Adapters;

use Netflex\DBAL\Concerns\PerformsQueries;
use Netflex\DBAL\Contracts\DatabaseAdapter;

final class ReadOnlyAdapter extends AbstractAdapter
{
    use PerformsQueries;
}
