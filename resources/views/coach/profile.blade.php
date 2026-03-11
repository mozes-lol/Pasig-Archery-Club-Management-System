@extends('layouts.app')

@section('title', 'Coach Profile')
@section('page-title', 'My Profile')

@push('page-styles')
<link rel="stylesheet" href="/css/pages/coach-profile.css">
@endpush

@section('content')
    <div class="page">
        <!-- Profile Header Card -->
        <div class="card profile-card">
            <div class="cover"></div>
            <div class="profile-top">
                <div class="avatar-wrap">
                    <div class="avatar" id="avatarBox" title="Click to change photo">
                        <div class="avatar-placeholder" id="avatarPlaceholder">
                            <svg viewBox="0 0 24 24" fill="none" stroke="#8fa0b8" stroke-width="1.5">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <path d="M3 17l5-5 4 4 3-3 6 6"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                            </svg>
                        </div>
                        <img id="avatarImg" src="" alt="Avatar" style="display:none;">
                    </div>
                    <label class="avatar-upload-hint" for="avatarInput" title="Upload photo">
                        <svg viewBox="0 0 24 24"><path d="M3 17v3h3l11-11-3-3L3 17zm19.7-11.3a1 1 0 000-1.4l-1.9-1.9a1 1 0 00-1.4 0l-1.5 1.5 3.3 3.3 1.5-1.5z"/></svg>
                    </label>
                    <input type="file" id="avatarInput" accept="image/*">
                </div>

                <div class="profile-info">
                    <div class="profile-name">
                        <span id="displayName">Coach Juan</span>
                        <button class="edit-icon-btn" id="openNameEdit" title="Edit name">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="profile-role" id="displayRole">Club Instructor</div>
                </div>
            </div>
        </div>

        <!-- Personal Info Card -->
        <div class="card section-card">
            <div class="section-header">
                <div class="section-title">Personal Info</div>
                <button class="edit-icon-btn" id="openInfoEdit" title="Edit personal info">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </button>
            </div>
            <div class="section-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value" id="infoName">Juan Dela Cruz</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value" id="infoEmail">juandelacruz@gmail.com</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value" id="infoPhone">(+63) 9123456789</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Pronouns</div>
                        <div class="info-value" id="infoPronouns">He/Him/His</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Name & Role -->
    <div class="modal-overlay" id="nameModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Edit Profile</div>
                <button class="modal-close" id="closeNameModal">✕</button>
            </div>
            <div class="modal-grid">
                <div class="modal-field" style="grid-column: span 2;">
                    <label>Display Name</label>
                    <input type="text" id="inputDisplayName" value="Coach Juan">
                </div>
                <div class="modal-field" style="grid-column: span 2;">
                    <label>Role / Title</label>
                    <input type="text" id="inputRole" value="Club Instructor">
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" id="cancelNameModal">Cancel</button>
                <button class="btn-save" id="saveNameModal">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Modal: Edit Personal Info -->
    <div class="modal-overlay" id="infoModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title">Edit Personal Info</div>
                <button class="modal-close" id="closeInfoModal">✕</button>
            </div>
            <div class="modal-grid">
                <div class="modal-field" style="grid-column: span 2;">
                    <label>Full Name</label>
                    <input type="text" id="inputFullName" value="Juan Dela Cruz">
                </div>
                <div class="modal-field">
                    <label>Email</label>
                    <input type="email" id="inputEmail" value="juandelacruz@gmail.com">
                </div>
                <div class="modal-field">
                    <label>Phone Number</label>
                    <input type="tel" id="inputPhone" value="(+63) 9123456789">
                </div>
                <div class="modal-field" style="grid-column: span 2;">
                    <label>Pronouns</label>
                    <input type="text" id="inputPronouns" value="He/Him/His">
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-cancel" id="cancelInfoModal">Cancel</button>
                <button class="btn-save" id="saveInfoModal">Save Changes</button>
            </div>
        </div>
    </div>

    <div class="toast" id="toast">Changes saved!</div>

    <script>
        // Avatar upload
        document.getElementById("avatarInput").addEventListener("change", function() {
            const file = this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById("avatarImg");
                img.src = e.target.result;
                img.style.display = "block";
                document.getElementById("avatarPlaceholder").style.display = "none";
            };
            reader.readAsDataURL(file);
        });

        // Modal helpers
        function openModal(id)  { document.getElementById(id).classList.add("open"); }
        function closeModal(id) { document.getElementById(id).classList.remove("open"); }

        function showToast(msg) {
            const t = document.getElementById("toast");
            t.textContent = msg;
            t.classList.add("show");
            setTimeout(() => t.classList.remove("show"), 2200);
        }

        // Close on overlay click
        document.querySelectorAll(".modal-overlay").forEach(overlay => {
            overlay.addEventListener("click", e => {
                if (e.target === overlay) overlay.classList.remove("open");
            });
        });

        // Name / Role modal
        document.getElementById("openNameEdit").addEventListener("click", () => openModal("nameModal"));
        document.getElementById("closeNameModal").addEventListener("click", () => closeModal("nameModal"));
        document.getElementById("cancelNameModal").addEventListener("click", () => closeModal("nameModal"));
        document.getElementById("saveNameModal").addEventListener("click", () => {
            if (window.ArcheryLoader) {
                ArcheryLoader.show();
                ArcheryLoader.setMessage("Saving profile changes...");
                setTimeout(() => {
                    document.getElementById("displayName").textContent = document.getElementById("inputDisplayName").value;
                    document.getElementById("displayRole").textContent = document.getElementById("inputRole").value;
                    if (window.ArcheryLoader) ArcheryLoader.hide();
                    closeModal("nameModal");
                    showToast("Profile updated!");
                }, 2000);
            } else {
                document.getElementById("displayName").textContent = document.getElementById("inputDisplayName").value;
                document.getElementById("displayRole").textContent = document.getElementById("inputRole").value;
                closeModal("nameModal");
                showToast("Profile updated!");
            }
        });

        // Personal Info modal
        document.getElementById("openInfoEdit").addEventListener("click", () => openModal("infoModal"));
        document.getElementById("closeInfoModal").addEventListener("click", () => closeModal("infoModal"));
        document.getElementById("cancelInfoModal").addEventListener("click", () => closeModal("infoModal"));
        document.getElementById("saveInfoModal").addEventListener("click", () => {
            if (window.ArcheryLoader) {
                ArcheryLoader.show();
                ArcheryLoader.setMessage("Saving personal info...");
                setTimeout(() => {
                    document.getElementById("infoName").textContent     = document.getElementById("inputFullName").value;
                    document.getElementById("infoEmail").textContent    = document.getElementById("inputEmail").value;
                    document.getElementById("infoPhone").textContent    = document.getElementById("inputPhone").value;
                    document.getElementById("infoPronouns").textContent = document.getElementById("inputPronouns").value;
                    if (window.ArcheryLoader) ArcheryLoader.hide();
                    closeModal("infoModal");
                    showToast("Personal info updated!");
                }, 2000);
            } else {
                document.getElementById("infoName").textContent     = document.getElementById("inputFullName").value;
                document.getElementById("infoEmail").textContent    = document.getElementById("inputEmail").value;
                document.getElementById("infoPhone").textContent    = document.getElementById("inputPhone").value;
                document.getElementById("infoPronouns").textContent = document.getElementById("inputPronouns").value;
                closeModal("infoModal");
                showToast("Personal info updated!");
            }
        });
    </script>
@endsection


