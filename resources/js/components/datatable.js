/**
 * ===================================
 * SI-MAGANG - DataTable Component
 * ===================================
 */

export class DataTable {
    constructor(tableElement, options = {}) {
        this.table = tableElement;
        this.options = {
            sortable: true,
            selectable: true,
            searchable: true,
            pagination: true,
            ...options
        };
        
        this.selectedRows = new Set();
        this.currentSort = { column: null, direction: 'asc' };
        
        this.init();
    }
    
    init() {
        if (this.options.sortable) {
            this.initSorting();
        }
        
        if (this.options.selectable) {
            this.initSelection();
        }
        
        if (this.options.searchable) {
            this.initSearch();
        }
        
        this.initBulkActions();
        this.initTooltips();
    }
    
    initSorting() {
        const headers = this.table.querySelectorAll('th[data-sortable]');
        headers.forEach(header => {
            header.style.cursor = 'pointer';
            header.classList.add('sortable');
            
            // Add sort icon
            const icon = document.createElement('i');
            icon.className = 'fas fa-sort ms-2 sort-icon';
            header.appendChild(icon);
            
            header.addEventListener('click', () => {
                this.sortTable(header);
            });
        });
    }
    
    sortTable(header) {
        const column = header.dataset.sortable;
        const tbody = this.table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        
        // Determine sort direction
        let direction = 'asc';
        if (this.currentSort.column === column && this.currentSort.direction === 'asc') {
            direction = 'desc';
        }
        
        // Update sort icons
        this.table.querySelectorAll('.sort-icon').forEach(icon => {
            icon.className = 'fas fa-sort ms-2 sort-icon';
        });
        
        const icon = header.querySelector('.sort-icon');
        icon.className = `fas fa-sort-${direction === 'asc' ? 'up' : 'down'} ms-2 sort-icon`;
        
        // Sort rows
        rows.sort((a, b) => {
            const aValue = this.getCellValue(a, column);
            const bValue = this.getCellValue(b, column);
            
            if (direction === 'asc') {
                return aValue.localeCompare(bValue, 'id', { numeric: true });
            } else {
                return bValue.localeCompare(aValue, 'id', { numeric: true });
            }
        });
        
        // Reorder rows
        rows.forEach(row => tbody.appendChild(row));
        
        // Update current sort
        this.currentSort = { column, direction };
    }
    
    getCellValue(row, column) {
        const cell = row.querySelector(`[data-sort="${column}"]`);
        if (cell) {
            return cell.dataset.value || cell.textContent.trim();
        }
        
        // Fallback: find by column index
        const headerIndex = Array.from(this.table.querySelectorAll('th')).findIndex(th => 
            th.dataset.sortable === column
        );
        
        if (headerIndex >= 0) {
            const cells = row.querySelectorAll('td');
            return cells[headerIndex]?.textContent.trim() || '';
        }
        
        return '';
    }
    
    initSelection() {
        // Select all checkbox
        const selectAllCheckbox = this.table.querySelector('input[data-select-all]');
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', () => {
                this.toggleSelectAll(selectAllCheckbox.checked);
            });
        }
        
        // Individual row checkboxes
        const rowCheckboxes = this.table.querySelectorAll('input[data-select-row]');
        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                this.toggleRowSelection(checkbox);
            });
        });
    }
    
    toggleSelectAll(checked) {
        const rowCheckboxes = this.table.querySelectorAll('input[data-select-row]');
        
        rowCheckboxes.forEach(checkbox => {
            checkbox.checked = checked;
            this.updateRowSelection(checkbox, checked);
        });
        
        this.updateBulkActions();
    }
    
    toggleRowSelection(checkbox) {
        this.updateRowSelection(checkbox, checkbox.checked);
        this.updateSelectAllState();
        this.updateBulkActions();
    }
    
    updateRowSelection(checkbox, selected) {
        const value = checkbox.value;
        
        if (selected) {
            this.selectedRows.add(value);
            checkbox.closest('tr')?.classList.add('selected');
        } else {
            this.selectedRows.delete(value);
            checkbox.closest('tr')?.classList.remove('selected');
        }
    }
    
    updateSelectAllState() {
        const selectAllCheckbox = this.table.querySelector('input[data-select-all]');
        if (!selectAllCheckbox) return;
        
        const rowCheckboxes = this.table.querySelectorAll('input[data-select-row]');
        const checkedCount = Array.from(rowCheckboxes).filter(cb => cb.checked).length;
        
        if (checkedCount === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCount === rowCheckboxes.length) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        }
    }
    
    initBulkActions() {
        const bulkActionButtons = document.querySelectorAll('[data-bulk-action]');
        bulkActionButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const action = button.dataset.bulkAction;
                this.handleBulkAction(action, button);
            });
        });
    }
    
    updateBulkActions() {
        const bulkActionButtons = document.querySelectorAll('[data-bulk-action]');
        const hasSelection = this.selectedRows.size > 0;
        
        bulkActionButtons.forEach(button => {
            button.disabled = !hasSelection;
            
            // Update button text with count
            const baseText = button.dataset.baseText || button.textContent;
            if (hasSelection) {
                button.textContent = `${baseText} (${this.selectedRows.size})`;
            } else {
                button.textContent = baseText;
            }
        });
    }
    
    handleBulkAction(action, button) {
        if (this.selectedRows.size === 0) {
            alert('Pilih minimal satu item untuk melakukan aksi ini!');
            return;
        }
        
        const selectedIds = Array.from(this.selectedRows);
        
        switch (action) {
            case 'delete':
                this.bulkDelete(selectedIds, button);
                break;
            case 'export':
                this.bulkExport(selectedIds, button);
                break;
            case 'activate':
                this.bulkActivate(selectedIds, button);
                break;
            case 'deactivate':
                this.bulkDeactivate(selectedIds, button);
                break;
            default:
                console.warn(`Unknown bulk action: ${action}`);
        }
    }
    
    async bulkDelete(ids, button) {
        const confirmed = await this.confirmAction(
            `Apakah Anda yakin ingin menghapus ${ids.length} item yang dipilih?`,
            'Tindakan ini tidak dapat dibatalkan!'
        );
        
        if (!confirmed) return;
        
        this.setButtonLoading(button, true);
        
        try {
            const response = await this.makeRequest('DELETE', button.dataset.url || '/bulk-delete', {
                ids: ids
            });
            
            if (response.success) {
                this.showNotification('Data berhasil dihapus', 'success');
                this.removeSelectedRows();
                this.clearSelection();
            } else {
                throw new Error(response.message || 'Gagal menghapus data');
            }
        } catch (error) {
            this.showNotification(error.message, 'error');
        } finally {
            this.setButtonLoading(button, false);
        }
    }
    
    async bulkExport(ids, button) {
        this.setButtonLoading(button, true);
        
        try {
            const response = await this.makeRequest('POST', button.dataset.url || '/bulk-export', {
                ids: ids,
                format: button.dataset.format || 'excel'
            });
            
            if (response.success && response.download_url) {
                // Trigger download
                const link = document.createElement('a');
                link.href = response.download_url;
                link.download = response.filename || 'export.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                this.showNotification('File berhasil diunduh', 'success');
            } else {
                throw new Error(response.message || 'Gagal mengekspor data');
            }
        } catch (error) {
            this.showNotification(error.message, 'error');
        } finally {
            this.setButtonLoading(button, false);
        }
    }
    
    initSearch() {
        const searchInput = document.querySelector('[data-table-search]');
        if (!searchInput) return;
        
        let searchTimeout;
        
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.performSearch(e.target.value);
            }, 300);
        });
    }
    
    performSearch(query) {
        const rows = this.table.querySelectorAll('tbody tr');
        const searchQuery = query.toLowerCase().trim();
        
        if (!searchQuery) {
            rows.forEach(row => {
                row.style.display = '';
                row.classList.remove('search-hidden');
            });
            return;
        }
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(searchQuery);
            
            if (matches) {
                row.style.display = '';
                row.classList.remove('search-hidden');
            } else {
                row.style.display = 'none';
                row.classList.add('search-hidden');
            }
        });
        
        this.updateSearchResults();
    }
    
    updateSearchResults() {
        const visibleRows = this.table.querySelectorAll('tbody tr:not(.search-hidden)');
        const totalRows = this.table.querySelectorAll('tbody tr').length;
        
        // Update search results info
        const searchInfo = document.querySelector('[data-search-info]');
        if (searchInfo) {
            searchInfo.textContent = `Menampilkan ${visibleRows.length} dari ${totalRows} data`;
        }
        
        // Show no results message if needed
        this.toggleNoResultsMessage(visibleRows.length === 0);
    }
    
    toggleNoResultsMessage(show) {
        let noResultsRow = this.table.querySelector('.no-results-row');
        
        if (show && !noResultsRow) {
            const tbody = this.table.querySelector('tbody');
            const colCount = this.table.querySelectorAll('thead th').length;
            
            noResultsRow = document.createElement('tr');
            noResultsRow.className = 'no-results-row';
            noResultsRow.innerHTML = `
                <td colspan="${colCount}" class="text-center py-4">
                    <i class="fas fa-search text-muted fa-2x mb-2"></i>
                    <p class="text-muted mb-0">Tidak ada data yang sesuai dengan pencarian</p>
                </td>
            `;
            
            tbody.appendChild(noResultsRow);
        } else if (!show && noResultsRow) {
            noResultsRow.remove();
        }
    }
    
    initTooltips() {
        const tooltipElements = this.table.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(element => {
            new bootstrap.Tooltip(element);
        });
    }
    
    removeSelectedRows() {
        this.selectedRows.forEach(id => {
            const checkbox = this.table.querySelector(`input[data-select-row][value="${id}"]`);
            const row = checkbox?.closest('tr');
            if (row) {
                row.remove();
            }
        });
    }
    
    clearSelection() {
        this.selectedRows.clear();
        
        const checkboxes = this.table.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
            checkbox.indeterminate = false;
        });
        
        this.updateBulkActions();
    }
    
    async confirmAction(message, details = '') {
        const fullMessage = details ? `${message}\n\n${details}` : message;
        return confirm(fullMessage);
    }
    
    async makeRequest(method, url, data = null) {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        };
        
        if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
            options.body = JSON.stringify(data);
        }
        
        const response = await fetch(url, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    }
    
    setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    }
    
    showNotification(message, type = 'info') {
        // Use global notification system
        if (window.SIMagang && window.SIMagang.utils.showNotification) {
            window.SIMagang.utils.showNotification(message, type);
        } else {
            alert(message);
        }
    }
    
    // Public methods
    getSelectedRows() {
        return Array.from(this.selectedRows);
    }
    
    selectRows(ids) {
        ids.forEach(id => {
            const checkbox = this.table.querySelector(`input[data-select-row][value="${id}"]`);
            if (checkbox) {
                checkbox.checked = true;
                this.updateRowSelection(checkbox, true);
            }
        });
        
        this.updateSelectAllState();
        this.updateBulkActions();
    }
    
    refresh() {
        // Reload table data
        window.location.reload();
    }
    
    destroy() {
        // Clean up event listeners and references
        this.selectedRows.clear();
        
        // Remove event listeners would go here
        // This is a simplified cleanup
        console.log('DataTable destroyed');
    }
}

// Auto-initialize data tables
document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('[data-datatable]');
    
    tables.forEach(table => {
        const options = {};
        
        // Parse options from data attributes
        if (table.dataset.sortable === 'false') options.sortable = false;
        if (table.dataset.selectable === 'false') options.selectable = false;
        if (table.dataset.searchable === 'false') options.searchable = false;
        
        // Initialize DataTable
        new DataTable(table, options);
    });
});

export default DataTable;