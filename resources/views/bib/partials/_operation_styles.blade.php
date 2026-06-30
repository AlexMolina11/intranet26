@once
<style>
    .bib-mode-wrap {
        max-width: 1180px;
        margin: 0 auto;
        padding: 20px 0;
    }

    .bib-mode-header {
        margin-bottom: 24px;
    }

    .bib-mode-header.is-centered {
        text-align: center;
        margin-bottom: 28px;
    }

    .bib-mode-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 12px;
        font-size: 14px;
        font-weight: 700;
        color: #779123;
        text-decoration: none;
    }

    .bib-mode-back:hover {
        color: #385506;
        text-decoration: none;
    }

    .bib-mode-title {
        font-size: 30px;
        font-weight: 800;
        color: #385506;
        margin: 0;
    }

    .bib-mode-subtitle {
        color: #656264;
        margin-top: 6px;
        font-size: 15px;
    }

    .bib-action-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .bib-action-card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-height: 210px;
        height: 100%;
        background: #ffffff;
        border: 1px solid #e8e8e8;
        border-radius: 18px;
        padding: 24px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 8px 22px rgba(0, 0, 0, .06);
        transition: transform .18s ease-in-out, box-shadow .18s ease-in-out, border-color .18s ease-in-out;
    }

    .bib-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, .10);
        border-color: rgba(119, 145, 35, .35);
        text-decoration: none;
        color: inherit;
    }

    .bib-action-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: #f1f5e8;
        color: #385506;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        margin-bottom: 16px;
    }

    .bib-action-card h2 {
        font-size: 20px;
        font-weight: 800;
        color: #385506;
        margin-bottom: 10px;
    }

    .bib-action-card p {
        color: #656264;
        font-size: 14px;
        line-height: 1.45;
        margin-bottom: 14px;
    }

    .bib-action-list {
        padding-left: 18px;
        margin: 0 0 14px 0;
        color: #333333;
        font-size: 14px;
        line-height: 1.65;
    }

    .bib-action-footer {
        margin-top: auto;
        font-size: 13px;
        font-weight: 800;
        color: #779123;
    }

    .bib-alert-count {
        display: inline-block;
        margin-left: 6px;
        background: #fee4e2;
        color: #b42318;
        border-radius: 999px;
        padding: 3px 8px;
        font-size: 12px;
        font-weight: 800;
    }

    .bib-alert-count.is-neutral {
        background: #f1f5e8;
        color: #385506;
    }

    .bib-section-spacer {
        margin-top: 18px;
    }

    @media (max-width: 1199.98px) {
        .bib-action-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575.98px) {
        .bib-mode-title {
            font-size: 25px;
        }

        .bib-action-grid {
            grid-template-columns: 1fr;
        }

        .bib-action-card {
            min-height: auto;
        }
    }
</style>
@endonce
