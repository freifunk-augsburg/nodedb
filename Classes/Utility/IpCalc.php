<?php

namespace C1\Nodedb\Utility;

    /***************************************************************
     *
     *  Copyright notice
     *
     *  (c) 2016 Manuel Munz <t3dev@comuno.net>, comuno.net
     *
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/


/**
 * IpCalc
 */
class IpCalc
{

//    public function ip2long($ip) {
//        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === true) {
//            return $this->ip2long6($ip);
//        }
//        if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === true) {
//            return $this->ip2long($ip);
//        }
//        return false;
//    }
//
//    public function long2ip($iplong) {
//        if(filter_var($iplong, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === true) {
//            return $this->long2ip6($iplong);
//        }
//        if(filter_var($iplong, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === true ) {
//            return $this->long2ip($iplong);
//        }
//        return false;
//    }

    public function ip2long6($ipv6)
    {
        $ip_n = inet_pton($ipv6);
        $ipv6long = NULL;
        $bits = 15; // 16 x 8 bit = 128bit
        while ($bits >= 0) {
            $bin = sprintf("%08b", (ord($ip_n[$bits])));
            $ipv6long = $bin . $ipv6long;
            $bits--;
        }
        return gmp_strval(gmp_init($ipv6long, 2), 10);
    }

    public function long2ip6($ipv6long)
    {
        $ipv6 = NULL;
        $bin = gmp_strval(gmp_init($ipv6long, 10), 2);
        if (strlen($bin) < 128) {
            $pad = 128 - strlen($bin);
            for ($i = 1; $i <= $pad; $i++) {
                $bin = "0" . $bin;
            }
        }
        $bits = 0;
        while ($bits <= 7) {
            $bin_part = substr($bin, ($bits * 16), 16);
            $ipv6 .= dechex(bindec($bin_part)) . ":";
            $bits++;
        }
        return inet_ntop(inet_pton(substr($ipv6, 0, -1)));
    }
}