<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v18/enums/advertising_channel_type.proto

namespace Google\Ads\GoogleAds\V18\Enums\AdvertisingChannelTypeEnum;

use UnexpectedValueException;

/**
 * Enum describing the various advertising channel types.
 *
 * Protobuf type <code>google.ads.googleads.v18.enums.AdvertisingChannelTypeEnum.AdvertisingChannelType</code>
 */
class AdvertisingChannelType
{
    /**
     * Not specified.
     *
     * Generated from protobuf enum <code>UNSPECIFIED = 0;</code>
     */
    const UNSPECIFIED = 0;
    /**
     * Used for return value only. Represents value unknown in this version.
     *
     * Generated from protobuf enum <code>UNKNOWN = 1;</code>
     */
    const UNKNOWN = 1;
    /**
     * Search Network. Includes display bundled, and Search+ campaigns.
     *
     * Generated from protobuf enum <code>SEARCH = 2;</code>
     */
    const SEARCH = 2;
    /**
     * Google Display Network only.
     *
     * Generated from protobuf enum <code>DISPLAY = 3;</code>
     */
    const DISPLAY = 3;
    /**
     * Shopping campaigns serve on the shopping property
     * and on google.com search results.
     *
     * Generated from protobuf enum <code>SHOPPING = 4;</code>
     */
    const SHOPPING = 4;
    /**
     * Hotel Ads campaigns.
     *
     * Generated from protobuf enum <code>HOTEL = 5;</code>
     */
    const HOTEL = 5;
    /**
     * Video campaigns.
     *
     * Generated from protobuf enum <code>VIDEO = 6;</code>
     */
    const VIDEO = 6;
    /**
     * App Campaigns, and App Campaigns for Engagement, that run
     * across multiple channels.
     *
     * Generated from protobuf enum <code>MULTI_CHANNEL = 7;</code>
     */
    const MULTI_CHANNEL = 7;
    /**
     * Local ads campaigns.
     *
     * Generated from protobuf enum <code>LOCAL = 8;</code>
     */
    const LOCAL = 8;
    /**
     * Smart campaigns.
     *
     * Generated from protobuf enum <code>SMART = 9;</code>
     */
    const SMART = 9;
    /**
     * Performance Max campaigns.
     *
     * Generated from protobuf enum <code>PERFORMANCE_MAX = 10;</code>
     */
    const PERFORMANCE_MAX = 10;
    /**
     * Local services campaigns.
     *
     * Generated from protobuf enum <code>LOCAL_SERVICES = 11;</code>
     */
    const LOCAL_SERVICES = 11;
    /**
     * Travel campaigns.
     *
     * Generated from protobuf enum <code>TRAVEL = 13;</code>
     */
    const TRAVEL = 13;
    /**
     * Demand Gen campaigns.
     *
     * Generated from protobuf enum <code>DEMAND_GEN = 14;</code>
     */
    const DEMAND_GEN = 14;

    private static $valueToName = [
        self::UNSPECIFIED => 'UNSPECIFIED',
        self::UNKNOWN => 'UNKNOWN',
        self::SEARCH => 'SEARCH',
        self::DISPLAY => 'DISPLAY',
        self::SHOPPING => 'SHOPPING',
        self::HOTEL => 'HOTEL',
        self::VIDEO => 'VIDEO',
        self::MULTI_CHANNEL => 'MULTI_CHANNEL',
        self::LOCAL => 'LOCAL',
        self::SMART => 'SMART',
        self::PERFORMANCE_MAX => 'PERFORMANCE_MAX',
        self::LOCAL_SERVICES => 'LOCAL_SERVICES',
        self::TRAVEL => 'TRAVEL',
        self::DEMAND_GEN => 'DEMAND_GEN',
    ];

    public static function name($value)
    {
        if (!isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no name defined for value %s', __CLASS__, $value));
        }
        return self::$valueToName[$value];
    }


    public static function value($name)
    {
        $const = __CLASS__ . '::' . strtoupper($name);
        if (!defined($const)) {
            throw new UnexpectedValueException(sprintf(
                    'Enum %s has no value defined for name %s', __CLASS__, $name));
        }
        return constant($const);
    }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(AdvertisingChannelType::class, \Google\Ads\GoogleAds\V18\Enums\AdvertisingChannelTypeEnum_AdvertisingChannelType::class);

