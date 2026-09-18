---
name: luwene
description: Product-specific frontend and UX skill for LUWENE, a fictional internal culinary kiosk system with two distinct surfaces: a customer-facing kiosk UI and a cashier/admin desktop-tablet UI. Use when building, modifying, reviewing, or polishing LUWENE frontend code, UI, UX, copy, responsive behavior, interactions, or visual design.
---

# LUWENE Frontend & Product Skill

## 0. Purpose

This skill defines the visual, interaction, copy, responsive, and frontend implementation rules for LUWENE.

LUWENE has one application and one backend, but it intentionally has two different user-facing surfaces:

1. **Kiosk**
   - For customers.
   - Touch-first.
   - Large controls.
   - Fast ordering flow.
   - Optimized for kiosk displays.
   - Minimal navigation and cognitive load.

2. **Desktop / Tablet**
   - For CASHIER and ADMIN.
   - Operational application.
   - Information-dense but readable.
   - Optimized for mouse, keyboard, and touch where appropriate.
   - Used for order processing, payment handling, menu management, reports, and administration.

Do not treat these as the same interface scaled up or down. They share the same product language and data model, but their interaction models, density, navigation, and layout priorities are different.

---

# 1. Design Read

Before writing or modifying UI code, make a one-line design read:

> Reading this as: an internal culinary kiosk system with a touch-first customer ordering surface and a practical desktop/tablet operations surface, using a distinctive food-service visual language rather than a generic SaaS dashboard.

If the existing project already establishes a stronger brand direction, preserve it unless the user explicitly asks for a visual overhaul.

Do not invent a new visual identity on every page.

---

# 2. Core Product Principles

## 2.1 One Product, Two Surfaces

The kiosk and operations UI must feel like LUWENE, not two unrelated products.

Share:
- Brand identity.
- Color tokens.
- Typography family.
- Icon family.
- Product imagery treatment.
- Status semantics.
- Button language.
- Component naming.
- Spacing tokens where practical.

Do not blindly share:
- Navigation.
- Information density.
- Table layouts.
- Interaction patterns.
- Page composition.
- Control sizes.

## 2.2 Task Before Decoration

Every visual decision must support an actual task.

For kiosk:
- Choose food.
- Customize food.
- Add to cart.
- Review order.
- Complete order.

For cashier:
- Find order.
- Confirm payment.
- Move order through its workflow.
- Resolve operational exceptions.

For admin:
- Inspect business data.
- Manage catalog.
- Manage users.
- Review reports.
- Change operational configuration.

Do not add visual effects merely because they look impressive.

## 2.3 No Generic AI UI

Avoid default generated-interface patterns unless the product brief specifically calls for them.

Do not automatically use:
- Purple/blue AI gradients.
- Huge centered hero sections.
- Generic glassmorphism.
- Excessive rounded cards.
- Three-card feature layouts.
- Dashboard cards for every number.
- Random blobs.
- Decorative gradients with no functional purpose.
- Excessive shadows.
- Excessive animation.
- Emoji as UI icons.
- Generic "modern", "seamless", "powerful", or "next-generation" copy.

The interface should look designed for a food kiosk operation, not like an AI-generated SaaS template.

---

# 3. Anti-Slop Copy Rules

Apply the principles of the referenced anti-slop copywriting skill.

Reference:
https://github.com/miqdadbadjuber/anti-slop/blob/main/skills/antislop-copywriting/SKILL.md

## 3.1 Write the UI Copy People Actually Need

Prefer:
- "Tambah ke keranjang"
- "Bayar sekarang"
- "Pesanan siap"
- "Pesanan dibatalkan"
- "Pilih ukuran"
- "Pilih topping"
- "Cek pesanan"

Avoid:
- "Nikmati pengalaman kuliner terbaik"
- "Rasakan perjalanan rasa yang tak terlupakan"
- "Solusi pemesanan modern dan seamless"
- "Elevate your dining experience"
- "Temukan pengalaman baru"

Use concrete language.

## 3.2 Never Invent Facts

Do not fabricate:
- Sales numbers.
- Customer counts.
- Ratings.
- Reviews.
- Testimonials.
- Product claims.
- Nutritional values.
- Preparation times.
- Discounts.
- Popularity labels.
- Business achievements.

If mock data is necessary, clearly treat it as sample/demo data in code or documentation.

## 3.3 Avoid AI Writing Tells

Avoid:
- Empty buzzwords.
- Significance inflation.
- Fake authority.
- "At its core".
- "Let's dive in".
- "Here's what you need to know".
- "Not just X, but Y".
- Forced rule-of-three copy.
- Fake-candid openings.
- Excessive sentence fragments.
- Excessive synonym cycling.
- Fake precision.
- Generic inspirational endings.

Use the shortest wording that communicates the task.

## 3.4 UI Labels Are Not Marketing Copy

A button should normally describe the action.

Good:
- "Tambah"
- "Lanjut ke pembayaran"
- "Konfirmasi pembayaran"
- "Tandai siap"
- "Simpan perubahan"
- "Nonaktifkan produk"

Bad:
- "Mulai perjalanan"
- "Jelajahi lebih jauh"
- "Unlock sekarang"
- "Experience LUWENE"

---

# 4. Visual Direction

The visual direction should feel like a real contemporary culinary kiosk.

Use the product category as a source of visual character:
- Food photography can carry visual weight.
- Menu categories can have strong hierarchy.
- Product cards can feel tactile without becoming toy-like.
- Price and quantity should be immediately readable.
- Color can reinforce food categories and actions.
- Brand accents should be deliberate rather than spread everywhere.

Avoid turning the entire UI into a restaurant landing page.

The kiosk is an ordering tool.

The operations UI is a work tool.

---

# 5. KIOSK SURFACE

## 5.1 Primary Goal

Minimize the time and effort required for a customer to go from menu browsing to completed order.

The kiosk should be:
- Touch-first.
- Easy to scan.
- Forgiving of accidental taps.
- Readable from a normal standing distance.
- Simple enough to use without staff assistance.

## 5.2 Kiosk Layout

Prefer a structure such as:

```text
+------------------------------------------------------+
| LUWENE                         Cart / Order Summary  |
+------------------------------------------------------+
| Category navigation                                  |
+------------------------------------------------------+
|                                                      |
| Product grid                                         |
|                                                      |
|                                                      |
+------------------------------------------------------+
| Optional persistent cart / checkout action           |
+------------------------------------------------------+
```

The exact composition may change based on the kiosk aspect ratio.

Do not force a desktop navigation sidebar into the kiosk.

## 5.3 Touch Targets

Interactive controls must be comfortably tappable.

Prefer:
- Large product cards.
- Large quantity controls.
- Large primary CTA.
- Clear spacing between destructive and constructive actions.
- Generous hit areas around icons.

Do not create tiny icon-only controls for important kiosk actions.

## 5.4 Kiosk Navigation

Keep navigation shallow.

A customer should not need to understand the application structure.

Prefer:
- Categories.
- Product selection.
- Product customization.
- Cart.
- Checkout.
- Order confirmation.

Avoid:
- Complex nested menus.
- Administrative terminology.
- Breadcrumb-heavy navigation.
- Hamburger menus for essential actions.

## 5.5 Kiosk Product Cards

Product cards should make these immediately visible:
- Product image.
- Product name.
- Price.
- Availability.
- Primary action.

Optional:
- Short description.
- Small category indicator.
- Variant hint.

Do not overload cards with:
- Long descriptions.
- Multiple secondary actions.
- Technical metadata.
- Admin controls.

## 5.6 Product Customization

Customization should happen in a focused surface.

Use:
- Modal/dialog for simple customization.
- Dedicated step when customization is complex.

Always show:
- Selected options.
- Additional price.
- Updated item total.
- Clear confirmation action.

Avoid hidden price changes.

---

# 6. KIOSK CART & CHECKOUT

## 6.1 Cart

The customer must be able to understand:
- What they ordered.
- Quantity.
- Selected customization.
- Price per item.
- Total.

Quantity changes should update visibly.

Do not hide the cart behind an obscure interaction.

## 6.2 Checkout

Checkout should have a clear hierarchy:

```text
Order items
    ↓
Subtotal
    ↓
Discount, if applicable
    ↓
Total
    ↓
Payment / confirmation action
```

Do not make the user hunt for the final total.

## 6.3 Confirmation

After a successful order:
- Confirm that the order was created.
- Show the order identifier.
- Show current order status.
- Give a clear next action.

Do not use vague success messages such as:
- "Everything is awesome!"
- "You're all set for an amazing experience!"

Prefer:
- "Pesanan #LW-1024 berhasil dibuat."
- "Pesanan sedang diproses."

Only use a real order number if it exists. Otherwise use clearly marked mock/demo data.

---

# 7. CASHIER SURFACE

## 7.1 Primary Goal

The cashier interface is a task-oriented operations tool.

Optimize for:
- Fast scanning.
- Order queue visibility.
- Status recognition.
- Payment handling.
- Low interaction cost.

## 7.2 Desktop Layout

A typical composition:

```text
+----------------+--------------------------------------+
| Navigation     | Header / operational context         |
|                +--------------------------------------+
| Orders         |                                      |
| Payments       | Main work area                       |
| Transactions   |                                      |
|                |                                      |
+----------------+--------------------------------------+
```

A sidebar is appropriate when it improves navigation.

Do not copy the kiosk layout.

## 7.3 Order Queue

The order queue should prioritize:
1. Order identifier.
2. Current status.
3. Time/order age.
4. Customer/order context needed by staff.
5. Total.
6. Next valid action.

Use status colors carefully. Color should reinforce a label, not replace it.

Example:

```text
#LW-1024
Menunggu pembayaran
Rp 42.000
[Konfirmasi pembayaran]
```

## 7.4 Operational Density

Cashier UI can be denser than kiosk UI.

Use:
- Compact rows.
- Tables where scanning many records matters.
- Sticky controls when appropriate.
- Clear column hierarchy.
- Keyboard-friendly interaction.

But do not compress everything until labels become difficult to scan.

---

# 8. ADMIN SURFACE

## 8.1 Primary Goal

Admin UI supports management and inspection.

Typical areas:
- Dashboard.
- Products.
- Categories.
- Variants.
- Toppings.
- Orders.
- Transactions.
- Users.
- Reports.
- Settings.

## 8.2 Dashboard

Dashboard numbers must correspond to real data.

Prefer a small number of useful metrics:
- Revenue.
- Orders.
- Completed orders.
- Cancelled orders.
- Average order value.

Use charts when they answer a real question.

Do not create a chart merely to fill empty space.

## 8.3 Tables

Tables are appropriate for admin data.

Use them for:
- Products.
- Users.
- Orders.
- Transactions.

Prioritize:
- Useful columns.
- Search.
- Filtering.
- Sorting.
- Pagination when necessary.
- Clear row actions.

Do not turn every field into a visible column.

## 8.4 Forms

Admin forms should use explicit labels.

Prefer:

```text
Nama produk
[________________]

Harga
[________________]

Kategori
[ Pilih kategori ]

Status
[ Tersedia ]

[ Simpan perubahan ]
```

Avoid placeholder-only forms where labels disappear after input.

---

# 9. DESKTOP & TABLET RESPONSIVENESS

Desktop and tablet are one operational surface with adaptive layouts.

## 9.1 Breakpoint Intent

Use breakpoints based on task requirements, not device names alone.

Conceptually:
- Large desktop: full navigation and multi-column operational views.
- Smaller desktop: compressed navigation and content.
- Tablet: compact navigation, stacked panels, touch-friendly controls.
- Very narrow screens: do not pretend the operational UI is a kiosk.

## 9.2 Tablet

Tablet must remain usable with touch.

Increase:
- Hit areas.
- Row action spacing.
- Dialog dimensions where necessary.

Avoid:
- Hover-only functionality.
- Tiny table controls.
- Menus that require pixel-perfect cursor interaction.

## 9.3 Do Not Use Kiosk UI on Tablet by Accident

The tablet operations UI is not simply:

```text
desktop → mobile → kiosk
```

The kiosk is a separate product surface.

---

# 10. COMPONENT SYSTEM

Create a shared component foundation, then allow surface-specific composition.

## 10.1 Shared Components

Examples:
- Button.
- Input.
- Select.
- Dialog.
- Badge.
- Status indicator.
- Product image.
- Product price.
- Toast.
- Empty state.
- Loading state.
- Error state.

## 10.2 Kiosk Components

Examples:
- KioskHeader.
- CategoryBar.
- ProductGrid.
- ProductCard.
- CustomizationSheet.
- CartPanel.
- CheckoutSummary.
- OrderConfirmation.

## 10.3 Operations Components

Examples:
- AppSidebar.
- OperationsHeader.
- OrderQueue.
- OrderRow.
- OrderDetailPanel.
- PaymentPanel.
- DataTable.
- FilterBar.
- MetricCard.
- ReportChart.

Do not create one giant universal component with dozens of role-specific boolean props.

Prefer composition.

---

# 11. DESIGN TOKENS

Use semantic tokens rather than scattering raw colors and spacing throughout the application.

Conceptual token groups:

```text
--color-background
--color-surface
--color-surface-elevated
--color-text-primary
--color-text-secondary
--color-border
--color-brand
--color-brand-foreground
--color-success
--color-warning
--color-danger
--color-info

--radius-sm
--radius-md
--radius-lg

--space-1
--space-2
--space-3
--space-4
--space-6
--space-8
```

Exact values should come from the established LUWENE visual direction.

Do not invent a new palette per page.

---

# 12. TYPOGRAPHY

Typography should establish hierarchy before decoration.

Prioritize:
1. Product name.
2. Price.
3. Action.
4. Supporting information.

For operations:
1. Page/task title.
2. Operational status.
3. Important numeric values.
4. Secondary metadata.

Do not use huge display typography inside dense operational screens.

Do not use too many font families.

One primary type family is usually enough.

---

# 13. ICONS

Use one icon family consistently.

Do not hand-draw SVG icons when an appropriate icon library is available.

Icons should:
- Have consistent stroke/weight.
- Have predictable size.
- Support labels rather than replace critical labels.
- Be decorative only when they add no ambiguity.

For kiosk, pair important icons with text where meaning may be unclear.

---

# 14. MOTION

Motion should communicate state and hierarchy.

Good uses:
- Add-to-cart feedback.
- Dialog entrance.
- Status change.
- Loading.
- Button press feedback.
- Small layout transitions.

Avoid:
- Constant floating objects.
- Infinite decorative loops.
- Scroll hijacking.
- Excessive parallax.
- Animated every-element-on-load sequences.
- Motion that delays ordering.

Default motion intensity for LUWENE:
- Kiosk: 2-4.
- Cashier: 1-3.
- Admin: 1-3.

Animate primarily:
- `transform`
- `opacity`

Honor:

```css
@media (prefers-reduced-motion: reduce)
```

For reduced motion, remove non-essential transitions and animated effects.

---

# 15. ACCESSIBILITY

Accessibility is a product requirement, not polish.

Minimum expectations:
- Visible focus state.
- Keyboard navigation on operations UI.
- Sufficient color contrast.
- Semantic buttons and form controls.
- Labels for inputs.
- Meaningful alt text for relevant product imagery.
- Do not use color as the only status signal.
- Dialogs must have accessible names.
- Disabled states must remain understandable.

Kiosk-specific:
- Touch targets must be large.
- Important actions must be visually obvious.
- Error messages must be readable at a glance.

---

# 16. STATES

Every interactive surface should account for:

```text
Default
Loading
Success
Empty
Error
Disabled
Unavailable
Selected
Focused
```

For orders, also account for:

```text
PENDING
CONFIRMED
PREPARING
READY
COMPLETED
CANCELLED
```

Do not design only the happy path.

---

# 17. ORDER STATUS VISUAL LANGUAGE

Order status must be consistent across kiosk, cashier, and admin.

Use both:
- Text.
- Visual status treatment.

Never communicate status only through color.

Example:

```text
Menunggu
Dikonfirmasi
Sedang dibuat
Siap diambil
Selesai
Dibatalkan
```

The backend remains the source of truth. UI state must not invent transitions.

---

# 18. DATA INTEGRITY IN UI

The frontend must not pretend to own business truth.

Do not:
- Calculate final order totals as authoritative values.
- Mark payments as successful without backend confirmation.
- Allow arbitrary order status transitions.
- Assume a product remains available after a stale fetch.
- Show fabricated report numbers.

The frontend can display optimistic feedback when appropriate, but the server response remains authoritative.

---

# 19. REAL-TIME FEEL WITHOUT OVERENGINEERING

For the current LUWENE scope, polling is acceptable.

If an order status needs refreshing:
- Poll at a reasonable interval.
- Stop polling when the order reaches a terminal state.
- Stop polling when the relevant screen is no longer active.
- Handle request errors.
- Avoid overlapping requests.

Do not add WebSockets solely because "real-time" sounds more advanced.

---

# 20. COPY REVIEW BEFORE SHIP

Before considering a UI complete, read every visible string:

- Navigation.
- Buttons.
- Labels.
- Product descriptions.
- Empty states.
- Error states.
- Confirmation dialogs.
- Toasts.
- Order status.
- Checkout text.
- Admin table actions.

Flag anything that:
- Sounds generated.
- Makes an unsupported claim.
- Uses unnecessary buzzwords.
- Is vague about the action.
- Uses fake precision.
- Uses inconsistent terminology.
- Is grammatically awkward.

Replace it with plain functional language.

---

# 21. DESIGN REVIEW BEFORE SHIP

Ask:

### Kiosk
- Can a first-time customer understand the next action?
- Are touch targets large enough?
- Is the current order visible?
- Is the total obvious?
- Can a customer recover from an accidental selection?
- Is unnecessary navigation removed?

### Cashier
- Can the cashier identify what needs action immediately?
- Is order status obvious?
- Is the next valid action obvious?
- Can common tasks be performed with few interactions?
- Does the interface work with touch as well as mouse?

### Admin
- Can the admin find the needed management area quickly?
- Are tables scannable?
- Are forms clear?
- Are destructive actions protected?
- Do dashboard numbers come from actual data?

### All surfaces
- Does the interface feel like LUWENE?
- Is the copy concrete?
- Are states handled?
- Is accessibility preserved?
- Is motion purposeful?
- Is anything present only because it looks impressive?

---

# 22. Anti-Pattern Checklist

Do not ship these without a concrete reason:

- Generic SaaS sidebar copied into kiosk.
- Giant hero section inside an ordering flow.
- Tiny kiosk buttons.
- Icon-only important actions.
- Excessive rounded cards.
- Every metric inside a card.
- Random gradients.
- Glass panels everywhere.
- Decorative blobs.
- Fake testimonials.
- Fake ratings.
- Fake sales numbers.
- Fake "popular" labels.
- AI-sounding marketing copy.
- Emoji used as interface icons.
- Hover-only actions on tablet.
- Tables that expose every database field.
- Infinite animation.
- Loading spinners with no timeout/error handling.
- Client-side-only authorization.
- Client-controlled prices.
- Client-controlled payment state.

---

# 23. Technical Defaults

When no existing project constraint says otherwise:

- React or Next.js.
- Tailwind CSS for styling.
- A maintained component library or project-owned components.
- One icon family.
- Semantic design tokens.
- CSS Grid for structured layouts.
- Flexbox for simple one-dimensional alignment.
- Responsive breakpoints based on layout requirements.
- Motion only where it improves comprehension.
- Server-side business rules.
- Client-side validation for immediate feedback, server-side validation for authority.

Do not introduce a new library for a problem that existing project primitives already solve.

Do not mix multiple design systems.

---

# 24. Implementation Discipline

When modifying an existing LUWENE interface:

1. Inspect the existing structure.
2. Identify whether the surface is Kiosk or Operations.
3. Preserve existing useful tokens and patterns.
4. Fix hierarchy before decoration.
5. Fix copy before adding more copy.
6. Fix interaction before adding animation.
7. Test the important states.
8. Check desktop and tablet behavior for operations UI.
9. Check kiosk touch behavior independently.
10. Review the final UI against this skill.

Do not rewrite unrelated parts of the application simply to impose a preferred coding style.

---

# 25. Final Rule

LUWENE should feel like a real food-service system built for its actual environment.

The kiosk should feel:
- Fast.
- Clear.
- Tactile.
- Food-focused.

The cashier/admin surface should feel:
- Operational.
- Dense enough for work.
- Structured.
- Reliable.

Both should feel unmistakably like the same product.

Prefer a specific, useful interface over a visually impressive generic one.
