# Hawksama_HyvaUsedProductNotice

**Hawksama_HyvaUsedProductNotice** is a **Hyvä-compatible** Magento 2 module tailored for stores selling used or “no-warranty” items. It displays a clear notice on the **product page** and requires customers to **acknowledge** that the items have no warranty or return policy during **checkout**.

---

## Overview

1. **Product Page Notice**
    - If a product is flagged as “used,” this module automatically shows a short disclaimer on the product detail page, letting buyers know that return rights may be limited or nonexistent.

2. **Checkout Acknowledgement**
    - During checkout, customers must explicitly confirm (via a checkbox) that they understand these items **have no warranty** or **return policy**. This ensures clarity and reduces potential disputes.

3. **Hyvä Compatibility**
    - Built to work seamlessly with **Hyvä**. The module’s Magewire component integrates with Hyvä Checkout to prompt and store customer consent.

---

## Features

- **Easy Integration**: No complicated setup; simply activate and configure your used-product attribute.
- **Session-Based Consent**: Acknowledgement is remembered throughout checkout.
- **Adjustable Wording**: Tailor your messaging to match store policies and branding.
- **Lightweight**: Minimal performance overhead, focusing on clarity and compliance.
- **Hyvä-Ready**: Magewire-based flows ensure a clean, modern checkout experience.

---

## Configuration

1. **Used Product Attribute**
    - Add or update a product attribute (e.g., `used_product`) to identify items requiring a disclaimer.
2. **Enable the Module**
    - Once enabled, the frontend notice and checkout confirmation become active for products with the above attribute.
3. **Messaging**
    - Edit the disclaimer text to suit your store’s policy and local regulations (e.g., language about no returns, limited warranty, etc.).

---

## Use Cases

- **Second-Hand Electronics**: Let buyers know these items are sold “as is” with no returns.
- **Refurbished Goods**: Ensure customers acknowledge limited or nonexistent warranties.
- **Vintage Items**: Clarify that due to age/condition, standard return policies do not apply.

---

## Known Limitations

- **Hyvä Dependency**: Checkout acknowledgement requires Hyvä’s Magewire environment. If you use default Luma, you’ll need a separate solution.
- **Single-Attribute Check**: Currently, it checks only one attribute (`used_product`) to decide if an item is “used.”

---

## License & Contributing

- **License**: Distributed under the [MIT License](LICENSE).
- **Contributions**: Feedback and PRs are welcome. Feel free to open an issue or submit improvements to enhance used-product notice handling.

---

## Contact

For any questions or suggestions:
- **Maintainer**: [Alexandru Carabus](https://www.linkedin.com/in/alexandru-manuel-carabus/)
- Or email me to [manue971@icloud.com](mailto:manue971@icloud.com)
- Or open an issue in this repository.

**Thank you for using Hawksama_HyvaUsedProductNotice!** This module aims to provide clarity and reduce ambiguity for customers buying used items. Enjoy a more transparent and compliant shopping experience!  
