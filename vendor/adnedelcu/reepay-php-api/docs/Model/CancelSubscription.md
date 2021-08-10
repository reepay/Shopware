# CancelSubscription

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**notice_periods** | **int** | Optional override of the notice periods set for plan. See plan for the definition of notice periods. | [optional]
**notice_periods_after_current** | **bool** | Optional override of the notice periods after current setting for plan. See plan for the definition of notice periods. | [optional]
**expire_at** | **string** | Optional fixed date and time on when the subscription should expire. The fixed expire date takes precedence over notice periods and fixation periods. The fixed expire date must be after the end of the current periods. On the form `yyyy-MM-dd`, `yyyyMMdd`, `yyyy-MM-ddTHH:mm` and `yyyy-MM-ddTHH:mm:ss`. | [optional]

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)


