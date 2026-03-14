<?php
/**
 * Local dashboard content (shown when iframe is disabled)
 *
 * @package AbjadWidget
 * @subpackage Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

$abjad_widget_version = ABJAD_WIDGET_VERSION;
$abjad_widget_bmc_id  = get_option( 'abjad_widget_settings', array( 'id' => 'metatronslove' ) )['id'];
?>
<div class="abjad-local-dashboard">
    <h2><?php esc_html_e( 'Abjad Widget - Local Dashboard', 'abjad-widget' ); ?></h2>
    <p><?php esc_html_e( 'This dashboard shows local content because you have disabled the external dashboard. Below you can find information about potential user groups for this widget.', 'abjad-widget' ); ?></p>
    <p><?php esc_html_e( 'Version:', 'abjad-widget' ); ?> <strong><?php echo esc_html( $abjad_widget_version ); ?></strong></p>

    <hr>

    <h3><?php esc_html_e( 'Spiritual Seekers and Mystics', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Curious, introspective, open-minded, and drawn to esoteric knowledge. They may have a strong interest in uncovering hidden meanings or patterns in life. Occupations: Spiritual coaches, tarot readers, astrologers, or individuals involved in New Age practices. Ideological Spectrum: Likely to lean toward spiritual or metaphysical beliefs. They may see the tools as a way to connect with deeper truths or universal energies.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Numerologists and Gematria Enthusiasts', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Analytical, detail-oriented, and fascinated by the relationship between numbers and language. They may enjoy decoding symbolic meanings. Occupations: Freelance numerologists, writers on esoteric topics, or hobbyists exploring numerology. Ideological Spectrum: May range from those who view numerology as a fun intellectual exercise to those who believe in its profound spiritual significance.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Historians and Linguists', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Scholarly, methodical, and interested in historical or cultural contexts of numerical systems like Abjad. Occupations: Academics, researchers, or students studying Middle Eastern languages, history, or religious texts. Ideological Spectrum: Likely to approach the tools from a secular, academic perspective, focusing on their historical or linguistic significance.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Religious or Faith-Based Individuals', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Devout, reflective, and seeking deeper connections to their faith. They may use the tools to explore religious texts or divine messages. Occupations: Religious scholars, imams, priests, or laypeople with a strong interest in their faith’s mystical traditions. Ideological Spectrum: Likely to have a traditional or conservative worldview, using the tools to reinforce their spiritual beliefs.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Writers and Artists', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Creative, imaginative, and drawn to symbolic or abstract concepts. They may use the tools for inspiration or to add layers of meaning to their work. Occupations: Authors, poets, visual artists, or musicians. Ideological Spectrum: May range from secular creatives to those with a spiritual or mystical bent.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Puzzle and Riddle Enthusiasts', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Playful, intellectually curious, and enjoy solving complex problems or decoding patterns. Occupations: Hobbyists, puzzle designers, or educators. Ideological Spectrum: Likely to approach the tools as a form of entertainment or mental exercise, with little ideological attachment.', 'abjad-widget' ); ?></p>

    <h3><?php esc_html_e( 'Conspiracy Theorists and Alternative Thinkers', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'Personality Traits: Skeptical of mainstream narratives, drawn to uncovering hidden truths or patterns in systems. Occupations: Independent researchers, bloggers, or activists. Ideological Spectrum: May have a more radical or unconventional worldview, using the tools to support alternative theories or narratives.', 'abjad-widget' ); ?></p>

    <hr>

    <h3><?php esc_html_e( '☕ Support the Project', 'abjad-widget' ); ?></h3>
    <p><?php esc_html_e( 'If you like my project, you can buy me a coffee!', 'abjad-widget' ); ?></p>
    <p>
        <a href="https://www.buymeacoffee.com/<?php echo esc_attr( $abjad_widget_bmc_id ); ?>" target="_blank" class="button button-primary">
            <?php esc_html_e( 'Buy Me A Coffee', 'abjad-widget' ); ?>
        </a>
    </p>
    <p><?php esc_html_e( 'Thank you! 🙏', 'abjad-widget' ); ?></p>
</div>

<style>
.abjad-local-dashboard {
    padding: 20px;
    background: #fff;
}
.abjad-local-dashboard h3 {
    margin-top: 25px;
    color: #23282d;
    font-size: 16px;
    font-weight: 600;
}
.abjad-local-dashboard hr {
    margin: 20px 0;
    border: 0;
    border-top: 1px solid #ccc;
}
</style>
