<?php

namespace App\Const;

class MallYahoo
{
    const API_TOKEN = 'https://auth.login.yahoo.co.jp/yconnect/v2/token';
    const API_ORDER_LIST = 'https://circus.shopping.yahooapis.jp/ShoppingWebService/V1/orderList';
    const API_ORDER_INFO = 'https://circus.shopping.yahooapis.jp/ShoppingWebService/V1/orderInfo';

    const REGEX_BUYER_COMMENTS = '/<BuyerComments>(.*?)<\/BuyerComments>/s';
    const TAG_BUYER_COMMENTS = '<BuyerComments>%s</BuyerComments>';
    const PARAM_ORDER_LIST = <<<EOD
<Req>
<Search>
<Condition>
<OrderTimeFrom>%s</OrderTimeFrom>
<OrderTimeTo>%s</OrderTimeTo>
</Condition>
<Result>100</Result>
<Sort>-order_time</Sort>
<Field>OrderId,OrderTime</Field>
</Search>
<SellerId>%s</SellerId>
</Req>
EOD;

    const PARAM_ORDER_INFO = <<<EOD
<Req>
<Target>
<OrderId>%s</OrderId>
<Field>OrderId,Version,ParentOrderId,ChildOrderId,DeviceType,MobileCarrierName,IsSeen,IsSplit,CancelReason,CancelReasonDetail,IsRoyalty,IsRoyaltyFix,IsSeller,IsAffiliate,IsRatingB2s,NeedSnl,OrderTime,LastUpdateTime,Suspect,SuspectMessage,OrderStatus,StoreStatus,RoyaltyFixTime,SendConfirmTime,SendPayTime,PrintSlipTime,PrintDeliveryTime,PrintBillTime,BuyerComments,SellerComments,Notes,OperationUser,Referer,EntryPoint,HistoryId,UsageId,UseCouponData,TotalCouponDiscount,ShippingCouponFlg,ShippingCouponDiscount,CampaignPoints,IsMultiShip,MultiShipId,IsReadOnly,IsFirstClassDrugIncludes,IsFirstClassDrugAgreement,IsWelcomeGiftIncludes,YamatoCoopStatus,FraudHoldStatus,PublicationTime,IsYahooAuctionOrder,YahooAuctionMerchantId,YahooAuctionId,IsYahooAuctionDeferred,YahooAuctionCategoryType,YahooAuctionBidType,YahooAuctionBundleType,GoodStoreStatus,CurrentGoodStoreBenefitApply,CurrentPromoPkgApply,LineGiftOrderId,IsLineGiftOrder,PayStatus,SettleStatus,PayType,PayKind,PayMethod,PayMethodName,SellerHandlingCharge,PayActionTime,PayDate,PayNotes,SettleId,CardBrand,CardNumber,CardNumberLast4,CardExpireYear,CardExpireMonth,CardPayType,CardHolderName,CardPayCount,CardBirthDay,UseYahooCard,UseWallet,NeedBillSlip,NeedDetailedSlip,NeedReceipt,AgeConfirmField,AgeConfirmValue,AgeConfirmCheck,BillAddressFrom,BillFirstName,BillFirstNameKana,BillLastName,BillLastNameKana,BillZipCode,BillPrefecture,BillPrefectureKana,BillCity,BillCityKana,BillAddress1,BillAddress1Kana,BillAddress2,BillAddress2Kana,BillPhoneNumber,BillEmgPhoneNumber,BillMailAddress,BillSection1Field,BillSection1Value,BillSection2Field,BillSection2Value,PayNo,PayNoIssueDate,ConfirmNumber,PaymentTerm,IsApplePay,LineGiftPayMethodName,ShipStatus,ShipMethod,ShipMethodName,ShipRequestDate,ShipRequestTime,ShipNotes,ShipCompanyCode,ReceiveShopCode,ShipInvoiceNumber1,ShipInvoiceNumber2,ShipInvoiceNumberEmptyReason,ShipUrl,ArriveType,ShipDate,ArrivalDate,NeedGiftWrap,GiftWrapCode,GiftWrapType,GiftWrapMessage,NeedGiftWrapPaper,GiftWrapPaperType,GiftWrapName,Option1Field,Option1Type,Option1Value,Option2Field,Option2Type,Option2Value,ShipFirstName,ShipFirstNameKana,ShipLastName,ShipLastNameKana,ShipZipCode,ShipPrefecture,ShipPrefectureKana,ShipCity,ShipCityKana,ShipAddress1,ShipAddress1Kana,ShipAddress2,ShipAddress2Kana,ShipPhoneNumber,ShipEmgPhoneNumber,ShipSection1Field,ShipSection1Value,ShipSection2Field,ShipSection2Value,ReceiveSatelliteType,ReceiveSatelliteSettleMethod,ReceiveSatelliteMethod,ReceiveSatelliteCompanyName,ReceiveSatelliteShopCode,ReceiveSatelliteShopName,ReceiveSatelliteShipKind,ReceiveSatelliteYahooCode,ReceiveSatelliteCertificationNumber,CollectionDate,CashOnDeliveryTax,NumberUnitsShipped,ShipRequestTimeZoneCode,ShipInstructType,ShipInstructStatus,ReceiveShopType,ReceiveShopName,ExcellentDelivery,IsEazy,EazyDeliveryCode,EazyDeliveryName,IsSubscription,SubscriptionId,SubscriptionContinueCount,SubscriptionCycleType,SubscriptionCycleDate,IsLineGiftShippable,ShippingDeadline,UseGiftCardData,PayCharge,ShipCharge,GiftWrapCharge,Discount,Adjustments,SettleAmount,UsePoint,GiftCardDiscount,TotalPrice,SettlePayAmount,IsGetPointFixAll,TotalMallCouponDiscount,IsGetStoreBonusFixAll,LineGiftCharge,LineId,ItemId,Title,SubCode,SubCodeOption,ItemOption,Inscription,IsUsed,ImageId,IsTaxable,ItemTaxRatio,Jan,ProductId,CategoryId,AffiliateRatio,UnitPrice,NonTaxUnitPrice,Quantity,PointAvailQuantity,ReleaseDate,PointFspCode,PointRatioY,PointRatioSeller,UnitGetPoint,IsGetPointFix,GetPointFixDate,CouponData,CouponDiscount,CouponUseNum,OriginalPrice,OriginalNum,LeadTimeText,LeadTimeStart,LeadTimeEnd,PriceType,PickAndDeliveryCode,PickAndDeliveryTransportRuleType,YamatoUndeliverableReason,StoreBonusRatioSeller,UnitGetStoreBonus,IsGetStoreBonusFix,GetStoreBonusFixDate,ItemYahooAucId,ItemYahooAucMerchantId,SellerId,LineGiftAccount,IsLogin,FspLicenseCode,FspLicenseName,GuestAuthId</Field>
</Target>
<SellerId>%s</SellerId>
</Req>
EOD;
}
