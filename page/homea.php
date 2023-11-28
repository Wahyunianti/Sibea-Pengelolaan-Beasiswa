<div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-indigo">
                            <div>
                                <i class="ri-function-line summary-icon bg-indigo mb-2"></i>
                                <div>Beasiswa</div>
                            </div>
                            <h4><?php $query = $connection->query("SELECT count(kd_beasiswa) as jumlah FROM beasiswa");
                                                    echo $query->fetch_assoc()["jumlah"]; ?></h4>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-indigo">
                            <div>
                                <i class="ri-group-line summary-icon bg-indigo mb-2"></i>
                                <div>Pengguna</div>
                            </div>
                            <h4><?php $query = $connection->query("SELECT count(id_user) as jumlah FROM user");
                                                    echo $query->fetch_assoc()["jumlah"]; ?></h4>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <a href="#"
                            class="text-dark text-decoration-none bg-white p-3 rounded shadow-sm d-flex justify-content-between summary-indigo">
                            <div>
                                <i class="ri-user-received-2-line summary-icon bg-indigo mb-2"></i>
                                <div>Pendaftar</div>
                            </div>
                            <h4><?php $query = $connection->query("SELECT count(kd_hasil) as jumlah FROM hasil");
                                                    echo $query->fetch_assoc()["jumlah"]; ?></h4>
                        </a>
                    </div>
                    
                </div>