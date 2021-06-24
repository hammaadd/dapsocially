<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Square Checkout lets merchants accept online payments for supported
 * payment types using a checkout workflow hosted on squareup.com.
 */
class Checkout implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $checkoutPageUrl;

    /**
     * @var bool|null
     */
    private $askForShippingAddress;

    /**
     * @var string|null
     */
    private $merchantSupportEmail;

    /**
     * @var string|null
     */
    private $prePopulateBuyerEmail;

    /**
     * @var Address|null
     */
    private $prePopulateShippingAddress;

    /**
     * @var string|null
     */
    private $redirectUrl;

    /**
     * @var Order|null
     */
    private $order;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var AdditionalRecipient[]|null
     */
    private $additionalRecipients;

    /**
     * Returns Id.
     *
     * ID generated by Square Checkout when a new checkout is requested.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     *
     * ID generated by Square Checkout when a new checkout is requested.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Checkout Page Url.
     *
     * The URL that the buyer's browser should be redirected to after the
     * checkout is completed.
     */
    public function getCheckoutPageUrl(): ?string
    {
        return $this->checkoutPageUrl;
    }

    /**
     * Sets Checkout Page Url.
     *
     * The URL that the buyer's browser should be redirected to after the
     * checkout is completed.
     *
     * @maps checkout_page_url
     */
    public function setCheckoutPageUrl(?string $checkoutPageUrl): void
    {
        $this->checkoutPageUrl = $checkoutPageUrl;
    }

    /**
     * Returns Ask for Shipping Address.
     *
     * If `true`, Square Checkout will collect shipping information on your
     * behalf and store that information with the transaction information in your
     * Square Dashboard.
     *
     * Default: `false`.
     */
    public function getAskForShippingAddress(): ?bool
    {
        return $this->askForShippingAddress;
    }

    /**
     * Sets Ask for Shipping Address.
     *
     * If `true`, Square Checkout will collect shipping information on your
     * behalf and store that information with the transaction information in your
     * Square Dashboard.
     *
     * Default: `false`.
     *
     * @maps ask_for_shipping_address
     */
    public function setAskForShippingAddress(?bool $askForShippingAddress): void
    {
        $this->askForShippingAddress = $askForShippingAddress;
    }

    /**
     * Returns Merchant Support Email.
     *
     * The email address to display on the Square Checkout confirmation page
     * and confirmation email that the buyer can use to contact the merchant.
     *
     * If this value is not set, the confirmation page and email will display the
     * primary email address associated with the merchant's Square account.
     *
     * Default: none; only exists if explicitly set.
     */
    public function getMerchantSupportEmail(): ?string
    {
        return $this->merchantSupportEmail;
    }

    /**
     * Sets Merchant Support Email.
     *
     * The email address to display on the Square Checkout confirmation page
     * and confirmation email that the buyer can use to contact the merchant.
     *
     * If this value is not set, the confirmation page and email will display the
     * primary email address associated with the merchant's Square account.
     *
     * Default: none; only exists if explicitly set.
     *
     * @maps merchant_support_email
     */
    public function setMerchantSupportEmail(?string $merchantSupportEmail): void
    {
        $this->merchantSupportEmail = $merchantSupportEmail;
    }

    /**
     * Returns Pre Populate Buyer Email.
     *
     * If provided, the buyer's email is pre-populated on the checkout page
     * as an editable text field.
     *
     * Default: none; only exists if explicitly set.
     */
    public function getPrePopulateBuyerEmail(): ?string
    {
        return $this->prePopulateBuyerEmail;
    }

    /**
     * Sets Pre Populate Buyer Email.
     *
     * If provided, the buyer's email is pre-populated on the checkout page
     * as an editable text field.
     *
     * Default: none; only exists if explicitly set.
     *
     * @maps pre_populate_buyer_email
     */
    public function setPrePopulateBuyerEmail(?string $prePopulateBuyerEmail): void
    {
        $this->prePopulateBuyerEmail = $prePopulateBuyerEmail;
    }

    /**
     * Returns Pre Populate Shipping Address.
     *
     * Represents a physical address.
     */
    public function getPrePopulateShippingAddress(): ?Address
    {
        return $this->prePopulateShippingAddress;
    }

    /**
     * Sets Pre Populate Shipping Address.
     *
     * Represents a physical address.
     *
     * @maps pre_populate_shipping_address
     */
    public function setPrePopulateShippingAddress(?Address $prePopulateShippingAddress): void
    {
        $this->prePopulateShippingAddress = $prePopulateShippingAddress;
    }

    /**
     * Returns Redirect Url.
     *
     * The URL to redirect to after checkout is completed with `checkoutId`,
     * Square's `orderId`, `transactionId`, and `referenceId` appended as URL
     * parameters. For example, if the provided redirect_url is
     * `http://www.example.com/order-complete`, a successful transaction redirects
     * the customer to:
     *
     * <pre><code>http://www.example.com/order-complete?checkoutId=xxxxxx&amp;orderId=xxxxxx&amp;
     * referenceId=xxxxxx&amp;transactionId=xxxxxx</code></pre>
     *
     * If you do not provide a redirect URL, Square Checkout will display an order
     * confirmation page on your behalf; however Square strongly recommends that
     * you provide a redirect URL so you can verify the transaction results and
     * finalize the order through your existing/normal confirmation workflow.
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * Sets Redirect Url.
     *
     * The URL to redirect to after checkout is completed with `checkoutId`,
     * Square's `orderId`, `transactionId`, and `referenceId` appended as URL
     * parameters. For example, if the provided redirect_url is
     * `http://www.example.com/order-complete`, a successful transaction redirects
     * the customer to:
     *
     * <pre><code>http://www.example.com/order-complete?checkoutId=xxxxxx&amp;orderId=xxxxxx&amp;
     * referenceId=xxxxxx&amp;transactionId=xxxxxx</code></pre>
     *
     * If you do not provide a redirect URL, Square Checkout will display an order
     * confirmation page on your behalf; however Square strongly recommends that
     * you provide a redirect URL so you can verify the transaction results and
     * finalize the order through your existing/normal confirmation workflow.
     *
     * @maps redirect_url
     */
    public function setRedirectUrl(?string $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns Order.
     *
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * Sets Order.
     *
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     *
     * @maps order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Created At.
     *
     * The time when the checkout was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     *
     * The time when the checkout was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Additional Recipients.
     *
     * Additional recipients (other than the merchant) receiving a portion of this checkout.
     * For example, fees assessed on the purchase by a third party integration.
     *
     * @return AdditionalRecipient[]|null
     */
    public function getAdditionalRecipients(): ?array
    {
        return $this->additionalRecipients;
    }

    /**
     * Sets Additional Recipients.
     *
     * Additional recipients (other than the merchant) receiving a portion of this checkout.
     * For example, fees assessed on the purchase by a third party integration.
     *
     * @maps additional_recipients
     *
     * @param AdditionalRecipient[]|null $additionalRecipients
     */
    public function setAdditionalRecipients(?array $additionalRecipients): void
    {
        $this->additionalRecipients = $additionalRecipients;
    }

    /**
     * Encode this object to JSON
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        $json = [];
        $json['id']                         = $this->id;
        $json['checkout_page_url']          = $this->checkoutPageUrl;
        $json['ask_for_shipping_address']   = $this->askForShippingAddress;
        $json['merchant_support_email']     = $this->merchantSupportEmail;
        $json['pre_populate_buyer_email']   = $this->prePopulateBuyerEmail;
        $json['pre_populate_shipping_address'] = $this->prePopulateShippingAddress;
        $json['redirect_url']               = $this->redirectUrl;
        $json['order']                      = $this->order;
        $json['created_at']                 = $this->createdAt;
        $json['additional_recipients']      = $this->additionalRecipients;

        return array_filter($json, function ($val) {
            return $val !== null;
        });
    }
}
