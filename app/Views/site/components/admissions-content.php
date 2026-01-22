
    <!-- section 1 -->
 <section class="container py-5 my-5 h-100">
  <!-- Apply Now Section -->
  <div class="row justify-content-center">
    <!-- Left Column (Title) -->
    <div class="col-12 col-md-4 mb-4 mb-md-0">
      <h2 class="h2 fw-bold">Apply Now</h2>
    </div>

    <!-- Right Column (Form) -->
    <div class="col-12 col-md-8">
      <?php if (!empty($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
          <?php foreach ($_SESSION['errors'] as $fieldErrors): ?>
            <?php foreach ($fieldErrors as $error): ?>
              <p class="mb-0"><?= $error ?></p>
            <?php endforeach; ?>
          <?php endforeach; ?>
          <?php unset($_SESSION['errors']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="/AdmissionsPage/store">
        <input type="hidden" name="csrf_token" value="<?= \App\Middleware\CsrfMiddleware::generateToken(); ?>">

        <div class="mb-3">
          <label class="form-label">Full Name</label>
          <input
            type="text"
            name="full_name"
            class="form-control"
            placeholder="Full Name"
            value="<?= $_SESSION['old']['full_name'] ?? '' ?>"
            required
          />
        </div>

        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Email Address"
            value="<?= $_SESSION['old']['email'] ?? '' ?>"
            required
          />
        </div>

        <div class="mb-3">
          <label class="form-label">Age</label>
          <select name="age" class="form-select">
            <option disabled <?= empty($_SESSION['old']['age']) ? 'selected' : '' ?>>Age</option>
            <?php for ($i = 5; $i <= 18; $i++): ?>
              <option value="<?= $i ?>" <?= (isset($_SESSION['old']['age']) && $_SESSION['old']['age'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Message</label>
          <textarea
            name="message"
            class="form-control"
            rows="5"
            placeholder="Message"
          ><?= $_SESSION['old']['message'] ?? '' ?></textarea>
        </div>

        <div class="d-flex justify-content-center mt-5 mb-5">
          <button class="btn btn-primary btn-lg my-2" type="submit">
            Submit
          </button>
        </div>
      </form>

      <?php unset($_SESSION['old']); ?>
    </div>
  </div>
</section>

    <!-- section 2 -->
     <section class="container py-5 my-5 h-100 ">
        <!-- title -->
        <h2 class="h2 fw-bold ">
            Admissions Fees
        </h2>
        <!-- text  -->
        <div class="w-50 p-3 my-3">Fees at Misk Schools cover tuition and are fully inclusive of all student materials and services.</div>


        <!-- table  -->
        <div class="table-responsive" >
          <table class="table table-hover  my-4 ">
        <thead class="table-light">
            <tr>
            <td class="fw-bold">Header</td>
            <td class="fw-bold" >Header</td>
            <td class="fw-bold">Header</td>
            <td class="fw-bold" >Header</td>
            <td class="fw-bold" >Header</td>
            </tr>
        </thead>
        <tbody  class="table-group-divider">
            <tr>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            </tr>
            <tr>
            <td class="table-active">Text</td>
            <td class="table-active">Text</td>
            <td class="table-active">Text</td>
            <td>Text</td>
            <td>Text</td>
            </tr>
            <tr>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            <td>Text</td>
            </tr>
        </tbody>
        </table>
        </div>

        <!-- title2 -->
         <h4 class="h4 fw-bold " >What Fees Include (All Grades):</h4>

         <!-- list -->
          <div class="row g-5 ">
          <div class="col-12 col-sm-6 col-md-4">
             <ul class="custom-disc ">
            <li  >Tuition</li>
            <li >Books and stationery</li>
            <li   >Laptop computer*</li>
            <li >Uniform</li>
            </ul>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
             <ul class="custom-disc">
            <li  >Daily lunch and healthy snacks/li>
            <li  >Regular co-curricular and after school activities – on and off campus</li>
            <li >Sports uniform and equipment</li>
            <li  >Instruments for musicians*</li>
            <li >Field trips and excursions within KSA</li>
            </ul>
          </div>

          </div>
          <!-- text -->
           <p >* Personal use while a Misk Schools’ student</p>

     </section>


