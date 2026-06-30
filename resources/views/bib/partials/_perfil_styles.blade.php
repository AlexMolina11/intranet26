<style>
    .bib-profile-hero {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 18px;
        align-items: center;
        background: linear-gradient(135deg, #385506 0%, #779123 100%);
        border-radius: 22px;
        padding: 24px;
        color: #fff;
        box-shadow: 0 16px 36px rgba(56, 85, 6, .18);
        margin-bottom: 22px;
    }

    .bib-profile-hero h1 { margin: 0 0 6px; font-size: 28px; font-weight: 800; }
    .bib-profile-hero p { margin: 0; opacity: .92; }
    .bib-profile-actions { display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; }
    .bib-profile-actions .btn { white-space: nowrap; }

    .bib-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .bib-summary-card,
    .bib-section-card,
    .bib-alert-card {
        background: #fff;
        border: 1px solid rgba(101, 98, 100, .12);
        border-radius: 18px;
        box-shadow: 0 12px 26px rgba(0, 0, 0, .04);
    }

    .bib-summary-card { padding: 18px; min-height: 122px; display: flex; flex-direction: column; justify-content: space-between; }
    .bib-summary-icon { width: 42px; height: 42px; border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; background: rgba(160, 197, 37, .15); color: #385506; margin-bottom: 12px; }
    .bib-summary-title { color: #656264; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; }
    .bib-summary-value { color: #000; font-size: 30px; font-weight: 800; line-height: 1; margin-top: 6px; }
    .bib-summary-note { color: #656264; font-size: 13px; margin-top: 8px; }

    .bib-alert-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; margin-bottom: 22px; }
    .bib-alert-card { padding: 16px; border-left: 5px solid #a0c525; }
    .bib-alert-card.is-warning { border-left-color: #f0ad4e; }
    .bib-alert-card.is-danger { border-left-color: #dc3545; }
    .bib-alert-title { font-weight: 800; margin-bottom: 4px; }
    .bib-alert-text { color: #656264; margin: 0; font-size: 14px; }

    .bib-content-grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(340px, .65fr); gap: 20px; align-items: start; }
    .bib-section-card { margin-bottom: 20px; overflow: hidden; }
    .bib-section-header { padding: 18px 20px; border-bottom: 1px solid rgba(101, 98, 100, .12); display: flex; justify-content: space-between; gap: 16px; align-items: center; }
    .bib-section-header h2 { margin: 0; font-size: 18px; font-weight: 800; }
    .bib-section-header p { margin: 4px 0 0; color: #656264; font-size: 14px; }
    .bib-section-body { padding: 0; }

    .bib-clean-table { width: 100%; margin: 0; }
    .bib-clean-table th { color: #656264; font-size: 12px; text-transform: uppercase; letter-spacing: .04em; background: rgba(160, 197, 37, .06); border-bottom: 1px solid rgba(101, 98, 100, .12); }
    .bib-clean-table th,
    .bib-clean-table td { padding: 13px 16px; vertical-align: middle; }

    .bib-resource-title { font-weight: 800; color: #000; }
    .bib-resource-meta { color: #656264; font-size: 13px; margin-top: 2px; }
    .bib-badge { display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; padding: 5px 10px; background: rgba(101, 98, 100, .10); color: #656264; font-size: 12px; font-weight: 800; }
    .bib-badge.is-ok { background: rgba(160, 197, 37, .18); color: #385506; }
    .bib-badge.is-warning { background: rgba(240, 173, 78, .16); color: #9a6500; }
    .bib-badge.is-danger { background: rgba(220, 53, 69, .12); color: #b02a37; }

    .bib-empty-state { padding: 28px 20px; text-align: center; color: #656264; }
    .bib-empty-state i { font-size: 26px; color: #a0c525; margin-bottom: 8px; }
    .bib-muted-help { color: #656264; font-size: 12px; margin-top: 6px; }

    @media (max-width: 1200px) {
        .bib-summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .bib-content-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .bib-profile-hero { grid-template-columns: 1fr; }
        .bib-profile-actions { justify-content: flex-start; }
        .bib-summary-grid,
        .bib-alert-grid { grid-template-columns: 1fr; }
        .bib-section-header { flex-direction: column; align-items: flex-start; }
    }
</style>
