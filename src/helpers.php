<?php

function timestamp()
{
    return (int) (now()->timestamp.str_pad(now()->milli, 3, '0', STR_PAD_LEFT));
}
