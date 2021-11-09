<?php

declare(strict_types=1);

namespace KiloHealth\Subscription\Domain\ValueObject;

use Phoenix\Payment\Lib\AbstractEnum;

/**
 * @method static CurrencyCode getObject(string $currency)
 */
class CurrencyCode extends AbstractEnum
{
    /** UAE Dirham */
    public const CUR_AED = 'AED';

    /** Afghani */
    public const CUR_AFN = 'AFN';

    /** Lek */
    public const CUR_ALL = 'ALL';

    /** Armenian Dram */
    public const CUR_AMD = 'AMD';

    /** Netherlands Antillean Guilder */
    public const CUR_ANG = 'ANG';

    /** Kwanza */
    public const CUR_AOA = 'AOA';

    /** Argentine Peso */
    public const CUR_ARS = 'ARS';

    /** Australian Dollar */
    public const CUR_AUD = 'AUD';

    /** Aruban Florin */
    public const CUR_AWG = 'AWG';

    /** Azerbaijanian Manat */
    public const CUR_AZN = 'AZN';

    /** Convertible Mark */
    public const CUR_BAM = 'BAM';

    /** Barbados Dollar */
    public const CUR_BBD = 'BBD';

    /** Taka */
    public const CUR_BDT = 'BDT';

    /** Bulgarian Lev */
    public const CUR_BGN = 'BGN';

    /** Bahraini Dinar */
    public const CUR_BHD = 'BHD';

    /** Burundi Franc */
    public const CUR_BIF = 'BIF';

    /** Bermudian Dollar */
    public const CUR_BMD = 'BMD';

    /** Brunei Dollar */
    public const CUR_BND = 'BND';

    /** Boliviano */
    public const CUR_BOB = 'BOB';

    /** Mvdol */
    public const CUR_BOV = 'BOV';

    /** Brazilian Real */
    public const CUR_BRL = 'BRL';

    /** Bahamian Dollar */
    public const CUR_BSD = 'BSD';

    /** Ngultrum */
    public const CUR_BTN = 'BTN';

    /** Pula */
    public const CUR_BWP = 'BWP';

    /** Belarussian Ruble */
    public const CUR_BYR = 'BYR';

    /** Belize Dollar */
    public const CUR_BZD = 'BZD';

    /** Canadian Dollar */
    public const CUR_CAD = 'CAD';

    /** Congolese Franc */
    public const CUR_CDF = 'CDF';

    /** WIR Euro */
    public const CUR_CHE = 'CHE';

    /** Swiss Franc */
    public const CUR_CHF = 'CHF';

    /** WIR Franc */
    public const CUR_CHW = 'CHW';

    /** Unidad de Fomento */
    public const CUR_CLF = 'CLF';

    /** Chilean Peso */
    public const CUR_CLP = 'CLP';

    /** Yuan Renminbi */
    public const CUR_CNY = 'CNY';

    /** Colombian Peso */
    public const CUR_COP = 'COP';

    /** Unidad de Valor Real */
    public const CUR_COU = 'COU';

    /** Costa Rican Colon */
    public const CUR_CRC = 'CRC';

    /** Peso Convertible */
    public const CUR_CUC = 'CUC';

    /** Cuban Peso */
    public const CUR_CUP = 'CUP';

    /** Cabo Verde Escudo */
    public const CUR_CVE = 'CVE';

    /** Czech Koruna */
    public const CUR_CZK = 'CZK';

    /** Djibouti Franc */
    public const CUR_DJF = 'DJF';

    /** Danish Krone */
    public const CUR_DKK = 'DKK';

    /** Dominican Peso */
    public const CUR_DOP = 'DOP';

    /** Algerian Dinar */
    public const CUR_DZD = 'DZD';

    /** Egyptian Pound */
    public const CUR_EGP = 'EGP';

    /** Nakfa */
    public const CUR_ERN = 'ERN';

    /** Ethiopian Birr */
    public const CUR_ETB = 'ETB';

    /** Euro */
    public const CUR_EUR = 'EUR';

    /** Fiji Dollar */
    public const CUR_FJD = 'FJD';

    /** Falkland Islands Pound */
    public const CUR_FKP = 'FKP';

    /** Pound Sterling */
    public const CUR_GBP = 'GBP';

    /** Lari */
    public const CUR_GEL = 'GEL';

    /** Ghana Cedi */
    public const CUR_GHS = 'GHS';

    /** Gibraltar Pound */
    public const CUR_GIP = 'GIP';

    /** Dalasi */
    public const CUR_GMD = 'GMD';

    /** Guinea Franc */
    public const CUR_GNF = 'GNF';

    /** Quetzal */
    public const CUR_GTQ = 'GTQ';

    /** Guyana Dollar */
    public const CUR_GYD = 'GYD';

    /** Hong Kong Dollar */
    public const CUR_HKD = 'HKD';

    /** Lempira */
    public const CUR_HNL = 'HNL';

    /** Croatian Kuna */
    public const CUR_HRK = 'HRK';

    /** Gourde */
    public const CUR_HTG = 'HTG';

    /** Forint */
    public const CUR_HUF = 'HUF';

    /** Rupiah */
    public const CUR_IDR = 'IDR';

    /** New Israeli Sheqel */
    public const CUR_ILS = 'ILS';

    /** Indian Rupee */
    public const CUR_INR = 'INR';

    /** Iraqi Dinar */
    public const CUR_IQD = 'IQD';

    /** Iranian Rial */
    public const CUR_IRR = 'IRR';

    /** Iceland Krona */
    public const CUR_ISK = 'ISK';

    /** Jamaican Dollar */
    public const CUR_JMD = 'JMD';

    /** Jordanian Dinar */
    public const CUR_JOD = 'JOD';

    /** Yen */
    public const CUR_JPY = 'JPY';

    /** Kenyan Shilling */
    public const CUR_KES = 'KES';

    /** Som */
    public const CUR_KGS = 'KGS';

    /** Riel */
    public const CUR_KHR = 'KHR';

    /** Comoro Franc */
    public const CUR_KMF = 'KMF';

    /** North Korean Won */
    public const CUR_KPW = 'KPW';

    /** Won */
    public const CUR_KRW = 'KRW';

    /** Kuwaiti Dinar */
    public const CUR_KWD = 'KWD';

    /** Cayman Islands Dollar */
    public const CUR_KYD = 'KYD';

    /** Tenge */
    public const CUR_KZT = 'KZT';

    /** Kip */
    public const CUR_LAK = 'LAK';

    /** Lebanese Pound */
    public const CUR_LBP = 'LBP';

    /** Sri Lanka Rupee */
    public const CUR_LKR = 'LKR';

    /** Liberian Dollar */
    public const CUR_LRD = 'LRD';

    /** Loti */
    public const CUR_LSL = 'LSL';

    /** Libyan Dinar */
    public const CUR_LYD = 'LYD';

    /** Moroccan Dirham */
    public const CUR_MAD = 'MAD';

    /** Moldovan Leu */
    public const CUR_MDL = 'MDL';

    /** Malagasy Ariary */
    public const CUR_MGA = 'MGA';

    /** Denar */
    public const CUR_MKD = 'MKD';

    /** Kyat */
    public const CUR_MMK = 'MMK';

    /** Tugrik */
    public const CUR_MNT = 'MNT';

    /** Pataca */
    public const CUR_MOP = 'MOP';

    /** Ouguiya */
    public const CUR_MRO = 'MRO';

    /** Mauritius Rupee */
    public const CUR_MUR = 'MUR';

    /** Rufiyaa */
    public const CUR_MVR = 'MVR';

    /** Kwacha */
    public const CUR_MWK = 'MWK';

    /** Mexican Peso */
    public const CUR_MXN = 'MXN';

    /** Mexican Unidad de Inversion (UDI) */
    public const CUR_MXV = 'MXV';

    /** Malaysian Ringgit */
    public const CUR_MYR = 'MYR';

    /** Mozambique Metical */
    public const CUR_MZN = 'MZN';

    /** Namibia Dollar */
    public const CUR_NAD = 'NAD';

    /** Naira */
    public const CUR_NGN = 'NGN';

    /** Cordoba Oro */
    public const CUR_NIO = 'NIO';

    /** Norwegian Krone */
    public const CUR_NOK = 'NOK';

    /** Nepalese Rupee */
    public const CUR_NPR = 'NPR';

    /** New Zealand Dollar */
    public const CUR_NZD = 'NZD';

    /** Rial Omani */
    public const CUR_OMR = 'OMR';

    /** Balboa */
    public const CUR_PAB = 'PAB';

    /** Nuevo Sol */
    public const CUR_PEN = 'PEN';

    /** Kina */
    public const CUR_PGK = 'PGK';

    /** Philippine Peso */
    public const CUR_PHP = 'PHP';

    /** Pakistan Rupee */
    public const CUR_PKR = 'PKR';

    /** Zloty */
    public const CUR_PLN = 'PLN';

    /** Guarani */
    public const CUR_PYG = 'PYG';

    /** Qatari Rial */
    public const CUR_QAR = 'QAR';

    /** New Romanian Leu */
    public const CUR_RON = 'RON';

    /** Serbian Dinar */
    public const CUR_RSD = 'RSD';

    /** Russian Ruble */
    public const CUR_RUB = 'RUB';

    /** Rwanda Franc */
    public const CUR_RWF = 'RWF';

    /** Saudi Riyal */
    public const CUR_SAR = 'SAR';

    /** Solomon Islands Dollar */
    public const CUR_SBD = 'SBD';

    /** Seychelles Rupee */
    public const CUR_SCR = 'SCR';

    /** Sudanese Pound */
    public const CUR_SDG = 'SDG';

    /** Swedish Krona */
    public const CUR_SEK = 'SEK';

    /** Singapore Dollar */
    public const CUR_SGD = 'SGD';

    /** Saint Helena Pound */
    public const CUR_SHP = 'SHP';

    /** Leone */
    public const CUR_SLL = 'SLL';

    /** Somali Shilling */
    public const CUR_SOS = 'SOS';

    /** Surinam Dollar */
    public const CUR_SRD = 'SRD';

    /** South Sudanese Pound */
    public const CUR_SSP = 'SSP';

    /** Dobra */
    public const CUR_STD = 'STD';

    /** El Salvador Colon */
    public const CUR_SVC = 'SVC';

    /** Syrian Pound */
    public const CUR_SYP = 'SYP';

    /** Lilangeni */
    public const CUR_SZL = 'SZL';

    /** Baht */
    public const CUR_THB = 'THB';

    /** Somoni */
    public const CUR_TJS = 'TJS';

    /** Turkmenistan New Manat */
    public const CUR_TMT = 'TMT';

    /** Tunisian Dinar */
    public const CUR_TND = 'TND';

    /** Pa’anga */
    public const CUR_TOP = 'TOP';

    /** Turkish Lira */
    public const CUR_TRY = 'TRY';

    /** Trinidad and Tobago Dollar */
    public const CUR_TTD = 'TTD';

    /** New Taiwan Dollar */
    public const CUR_TWD = 'TWD';

    /** Tanzanian Shilling */
    public const CUR_TZS = 'TZS';

    /** Hryvnia */
    public const CUR_UAH = 'UAH';

    /** Uganda Shilling */
    public const CUR_UGX = 'UGX';

    /** US Dollar */
    public const CUR_USD = 'USD';

    /** US Dollar (Next day) */
    public const CUR_USN = 'USN';

    /** Uruguay Peso en Unidades Indexadas (URUIURUI) */
    public const CUR_UYI = 'UYI';

    /** Peso Uruguayo */
    public const CUR_UYU = 'UYU';

    /** Uzbekistan Sum */
    public const CUR_UZS = 'UZS';

    /** Bolivar */
    public const CUR_VEF = 'VEF';

    /** Dong */
    public const CUR_VND = 'VND';

    /** Vatu */
    public const CUR_VUV = 'VUV';

    /** Tala */
    public const CUR_WST = 'WST';

    /** CFA Franc BEAC */
    public const CUR_XAF = 'XAF';

    /** East Caribbean Dollar */
    public const CUR_XCD = 'XCD';

    /** CFA Franc BCEAO */
    public const CUR_XOF = 'XOF';

    /** CFP Franc */
    public const CUR_XPF = 'XPF';

    /** Yemeni Rial */
    public const CUR_YER = 'YER';

    /** Rand */
    public const CUR_ZAR = 'ZAR';

    /** Zambian Kwacha */
    public const CUR_ZMW = 'ZMW';

    /** Zimbabwe Dollar */
    public const CUR_ZWL = 'ZWL';

    public function isEqual(self $currencyCode): bool
    {
        return $currencyCode->getValue() === $this->getValue();
    }
}
