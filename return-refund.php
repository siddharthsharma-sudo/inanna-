<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Refund & Return Policy — INANNA</title>

  <style>
    :root{
      --card:#ffffff;
      --muted:#6b7280;
      --accent:#7c3aed;
    }

    *{box-sizing:border-box}

    body{
      font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      margin:0;
      background:#6b0000 !important; /* REQUIRED BACKGROUND COLOR */
      color:#0f172a;
    }

    .container-privacy{
      max-width:1000px;
      margin:108px auto;
      padding:28px;
    }

    .card{
      background:var(--card);
      border-radius:12px;
      padding:28px;
      box-shadow:0 6px 18px rgba(0,0,0,0.25);
    }

    h1{
      margin:0 0 12px;
      font-size:28px;
      font-weight:700;
    }

    h2{
      font-size:20px;
      margin-top:22px;
      font-weight:600;
    }

    li{
      line-height:1.6;
      color:#081124;
    }

    ul{
      margin:8px 0 16px 30px;
    }


    @media (max-width:600px){
      .container-privacy{
        margin:18px;
        padding:18px;
      }
    }
  </style>
</head>

<body>
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container-privacy" style="padding-top:60px;">

  <main class="card" role="main">

    <h1>Refund & Return Policy</h1>

    <p>At INANNA, we strive to deliver exceptional quality and service with every purchase. Please review our return and refund policy below:</p>

    <section>
      <h2>Made-to-Order Items</h2>
      <p>Our products are uniquely crafted to order, and as such, we do not accept returns or offer refunds once an order is confirmed.</p>
    </section>

    <section>
      <h2>Defective Items</h2>
      <p>If you receive a defective item, please contact us within <strong>48 hours</strong> at <strong>info@woi</strong> for assistance. We will arrange an inspection appointment to assess the issue.</p>
    </section>

    <section>
      <h2>Repair and Replacement</h2>
      <p>If the defect is due to a manufacturing error, we will repair or replace the items. However, defects resulting from misuse, mishandling, or general wear and tear may incur repair fees.</p>
    </section>

    <section>
      <h2>Exclusions</h2>
      <p>Our policy does not cover returns due to:</p>
      <ul>
        <li>Buyer’s remorse</li>
        <li>Dissatisfaction with design, color, or fit</li>
      </ul>
      <p>We encourage you to review product details, size charts, and customization options carefully before placing an order.</p>
    </section>

    <section>
      <h2>Shipping Costs</h2>
      <p>Customers are responsible for the cost of shipping items to us for inspection. We will cover the cost of shipping repaired or replaced items back to you.</p>
    </section>

    <section>
      <h2>Policy Changes</h2>
      <p>INANNA reserves the right to update this policy at any time. Changes will be effective immediately upon posting on our website. For questions, please contact our customer service team.</p>
    </section>

    <p>Thank you for choosing INANNA. We appreciate your understanding and support.</p>

  </main>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
